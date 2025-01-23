package com.localloop.ui.proposal;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.localloop.R;
import com.localloop.data.models.Trade;
import com.localloop.ui.advertisement.AdvertisementViewModel;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class MakeProposalDrawer extends BottomSheetDialogFragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_make_proposal, container, false);

        RecyclerView itemList = view.findViewById(R.id.itemList);
        itemList.setLayoutManager(new GridLayoutManager(getContext(), 4));

        AdvertisementViewModel viewModel = new ViewModelProvider(requireActivity()).get(AdvertisementViewModel.class);

        viewModel.getCurrentUserItems();

        viewModel.getItems().observe(getViewLifecycleOwner(), items -> {
            if (items != null) {
                MakeProposalDrawerAdapter adapter = new MakeProposalDrawerAdapter(items);
                itemList.setAdapter(adapter);
            }
        });

        view.findViewById(R.id.closeButton).setOnClickListener(v -> dismiss());

        view.findViewById(R.id.sendProposalButton).setOnClickListener(v -> {
            Trade trade = new Trade(viewModel.getAdvertisement().getId());
        });

        view.findViewById(R.id.addToCartButton).setOnClickListener(v -> {
        });

        return view;
    }
}
