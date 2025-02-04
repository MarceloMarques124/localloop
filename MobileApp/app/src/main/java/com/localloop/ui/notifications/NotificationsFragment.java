package com.localloop.ui.notifications;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.data.models.User;
import com.localloop.databinding.FragmentNotificationsBinding;

import java.util.ArrayList;
import java.util.List;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class NotificationsFragment extends Fragment {

    private final List<User> tradePartnersList = new ArrayList<>();
    private FragmentNotificationsBinding binding;
    private NotificationsViewModel notificationsViewModel;
    private TradePartnersAdapter adapter;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        notificationsViewModel = new ViewModelProvider(this).get(NotificationsViewModel.class);
        binding = FragmentNotificationsBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        setupRecyclerView();

        notificationsViewModel.getTradePartners().observe(getViewLifecycleOwner(), tradePartners -> {
            if (tradePartners != null) {
                adapter = new TradePartnersAdapter(tradePartners);
                binding.recyclerViewMessages.setAdapter(adapter);
            }
        });

        return root;
    }

    private void setupRecyclerView() {
        RecyclerView recyclerView = binding.recyclerViewMessages;
        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}