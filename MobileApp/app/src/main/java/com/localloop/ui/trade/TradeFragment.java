package com.localloop.ui.trade;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.data.models.Trade;
import com.localloop.data.models.TradeProposal;
import com.localloop.data.models.User;
import com.localloop.databinding.FragmentTradeBinding;
import com.localloop.ui.proposal.MakeProposalDrawer;
import com.localloop.utils.ArgumentKeys;

import java.util.Comparator;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class TradeFragment extends Fragment {

    private FragmentTradeBinding binding;
    private TradeViewModel viewModel;
    private Trade trade;
    private User currentUser;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        binding = FragmentTradeBinding.inflate(inflater, container, false);
        viewModel = new ViewModelProvider(this).get(TradeViewModel.class);

        RecyclerView recyclerView = binding.recyclerViewMessages;
        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));

        viewModel.getTradeLiveData().observe(getViewLifecycleOwner(), value -> {
            TradeProposalAdapter adapter = new TradeProposalAdapter(value.getTradeProposals());
            recyclerView.setAdapter(adapter);
            trade = value;

            TradeProposal proposal = getLastTradeProposal();

            if (proposal.getState() == TradeProposal.State.REJECTED) {
                showOnlyCounterProposal();
            }
        });

        viewModel.getUserLiveData().observe(getViewLifecycleOwner(), value -> {
            currentUser = value;

            TradeProposal tradeProposal = getLastTradeProposal();

            // esconder os botoes se o ultimo a enviar a proposta é o própio utilizador
            if (tradeProposal != null && tradeProposal.getUserId() == currentUser.getId()) {
                binding.buttons.setVisibility(View.GONE);
            }
        });


        getParentFragmentManager().setFragmentResultListener(ArgumentKeys.PROPOSAL_SENT, getViewLifecycleOwner(), (requestKey, result) -> {
            boolean proposalSent = result.getBoolean(ArgumentKeys.PROPOSAL_SENT, false);
            if (proposalSent) {
                viewModel.getTrade(trade.getId());
            }
        });

        binding.btnAccept.setOnClickListener(v -> onAccept());
        binding.btnReject.setOnClickListener(v -> onReject());
        binding.btnCounterProposal.setOnClickListener(v -> onCounterProposal());

        var arguments = getArguments();
        if (arguments != null) {
            String value = arguments.getString(ArgumentKeys.TRADE_ID);
            if (value != null) {
                int tradeId = Integer.parseInt(value);
                viewModel.getTrade(tradeId);
            }
        }

        return binding.getRoot();
    }

    private void onCounterProposal() {
        if (trade == null)
            return;

        Bundle args = new Bundle();
        args.putInt(ArgumentKeys.ADVERTISEMENT_ID, trade.getAdvertisementId());
        args.putInt(ArgumentKeys.USER_ID, currentUser.getId());
        args.putInt(ArgumentKeys.TRADE_ID, trade.getId());

        MakeProposalDrawer makeProposalDrawer = new MakeProposalDrawer();
        makeProposalDrawer.setArguments(args);
        makeProposalDrawer.show(getParentFragmentManager(), makeProposalDrawer.getTag());
    }

    public void onAccept() {
        if (trade == null) {
            return;
        }

        TradeProposal lastProposal = getLastTradeProposal();
        if (lastProposal != null) {
            viewModel.acceptTrade(lastProposal.getId());

            NavController navController = Navigation.findNavController(requireView());
            navController.navigateUp();
        }
    }

    public void onReject() {
        if (trade == null) {
            return;
        }

        TradeProposal tradeProposal = getLastTradeProposal();

        viewModel.rejectTradeProposal(tradeProposal.getId());

        viewModel.getTradeProposalMutableLiveData().observe(getViewLifecycleOwner(), value -> {
            if (value != null) {
                showOnlyCounterProposal();
                viewModel.getTrade(trade.getId());
            }
        });
    }

    private void showOnlyCounterProposal() {
        binding.btnReject.setVisibility(View.GONE);
        binding.btnAccept.setVisibility(View.GONE);
        binding.btnCounterProposal.setVisibility(View.VISIBLE);
    }

    public TradeProposal getLastTradeProposal() {
        if (trade == null || trade.getTradeProposals() == null || trade.getTradeProposals().isEmpty()) {
            return null;
        }

        return trade.getTradeProposals()
                .stream()
                .max(Comparator.comparingInt(TradeProposal::getId))
                .orElse(null);
    }
}