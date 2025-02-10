package com.localloop.ui.proposal;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.GridLayoutManager;

import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.localloop.R;
import com.localloop.api.requests.AddProposalRequest;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Item;
import com.localloop.databinding.FragmentMakeProposalBinding;
import com.localloop.utils.ArgumentKeys;

import java.util.List;
import java.util.stream.Collectors;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class MakeProposalDrawer extends BottomSheetDialogFragment {

    FragmentMakeProposalBinding binding;
    MakeProposalViewModel viewModel;
    int advertisementId;
    int userId;
    private int tradeId;


    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        binding = FragmentMakeProposalBinding.inflate(inflater, container, false);

        binding.itemList.setLayoutManager(new GridLayoutManager(getContext(), 4));

        viewModel = new ViewModelProvider(this).get(MakeProposalViewModel.class);

        Bundle args = getArguments();
        if (args != null) {
            advertisementId = args.getInt(ArgumentKeys.ADVERTISEMENT_ID);
            userId = args.getInt(ArgumentKeys.USER_ID);
            tradeId = args.getInt(ArgumentKeys.TRADE_ID);
        }

        if (userId != 0) {
            viewModel.getUserItems(userId);
        } else {
            viewModel.fetchCurrentUserItems();
        }

        viewModel.getItemsLiveData().observe(getViewLifecycleOwner(), items -> {
            if (items != null) {
                MakeProposalDrawerAdapter adapter = new MakeProposalDrawerAdapter(items);
                binding.itemList.setAdapter(adapter);
            }
        });

        viewModel.getTradeMutableLiveData().observe(getViewLifecycleOwner(), createTrade -> {
            if (createTrade != null) {
                Toast.makeText(requireContext(), R.string.PROPOSAL_SENT, Toast.LENGTH_SHORT).show();
                sendProposalSuccess();
                dismiss();
            }
        });

        binding.closeButton.setOnClickListener(v -> dismiss());

        binding.sendProposalButton.setOnClickListener(v -> {
            MakeProposalDrawerAdapter adapter = (MakeProposalDrawerAdapter) binding.itemList.getAdapter();

            if (adapter == null) {
                return;
            }

            List<Item> selectedItems = adapter.getSelectedItems();

            if (selectedItems.isEmpty()) {
                Toast.makeText(requireContext(), getString(R.string.PLEASE_SELECT_AT_LEAST_ONE_ITEM), Toast.LENGTH_SHORT).show();
                return;
            }

            new AlertDialog.Builder(requireContext())
                    .setTitle(getString(R.string.CONFIRM_PROPOSAL_SEND))
                    .setMessage(getString(R.string.ARE_YOU_SURE_YOU_WANT_TO_SEND_THIS_PROPOSAL))
                    .setPositiveButton(getString(R.string.YES), (dialog, which) -> {
                        if (tradeId > 0) {
                            addProposal(selectedItems);
                        } else {
                            initTrade(selectedItems);
                        }
                    })
                    .setNegativeButton(getString(R.string.NO), (dialog, which) -> dialog.dismiss())
                    .show();
        });

        binding.addToCartButton.setOnClickListener(v -> {
        });

        return binding.getRoot();
    }

    private void initTrade(List<Item> selectedItems) {
        String message = binding.messageInput.getText().toString();
        List<Integer> itemIds = selectedItems.stream().map(Item::getId).collect(Collectors.toList());

        viewModel.initTrade(new InitTradeRequest(advertisementId, message, itemIds));
    }

    private void addProposal(List<Item> selectedItems) {
        String message = binding.messageInput.getText().toString();
        List<Integer> itemIds = selectedItems.stream().map(Item::getId).collect(Collectors.toList());

        viewModel.addProposal(tradeId, new AddProposalRequest(itemIds, message));
    }

    private void sendProposalSuccess() {
        Bundle result = new Bundle();
        result.putBoolean(ArgumentKeys.PROPOSAL_SENT, true);
        getParentFragmentManager().setFragmentResult(ArgumentKeys.PROPOSAL_SENT, result);
    }
}
