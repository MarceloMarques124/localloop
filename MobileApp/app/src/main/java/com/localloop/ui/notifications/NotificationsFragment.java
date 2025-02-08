package com.localloop.ui.notifications;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.LinearLayoutManager;

import com.google.android.material.tabs.TabLayout;
import com.localloop.R;
import com.localloop.databinding.FragmentNotificationsBinding;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class NotificationsFragment extends Fragment {

    private FragmentNotificationsBinding binding;
    private NotificationsViewModel viewModel;
    private TradesAdapter adapter;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        viewModel = new ViewModelProvider(this).get(NotificationsViewModel.class);
        binding = FragmentNotificationsBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        adapter = new TradesAdapter();

        setupRecyclerViews();
        setupTabLayout();
        viewModel.getSentTrades();

        viewModel.getSentTradesLiveData().observe(getViewLifecycleOwner(), sentTrades -> adapter.updateList(sentTrades));
        viewModel.getReceivedTradesLiveData().observe(getViewLifecycleOwner(), receivedTrades -> adapter.updateList(receivedTrades));

        return root;
    }

    private void setupRecyclerViews() {
        binding.recyclerViewSentTrades.setLayoutManager(new LinearLayoutManager(getContext()));
        binding.recyclerViewSentTrades.setAdapter(adapter);

        binding.recyclerViewReceivedTrades.setLayoutManager(new LinearLayoutManager(getContext()));
        binding.recyclerViewReceivedTrades.setAdapter(adapter);

        binding.recyclerViewSentTrades.setVisibility(View.VISIBLE);
        binding.recyclerViewReceivedTrades.setVisibility(View.GONE);
    }

    private void setupTabLayout() {
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText(R.string.SENT_TRADES));
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText(R.string.RECEIVED_TRADES));

        binding.tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                if (tab.getPosition() == 0) {
                    binding.recyclerViewSentTrades.setVisibility(View.VISIBLE);
                    binding.recyclerViewReceivedTrades.setVisibility(View.GONE);
                    viewModel.getSentTrades();

                } else {
                    binding.recyclerViewSentTrades.setVisibility(View.GONE);
                    binding.recyclerViewReceivedTrades.setVisibility(View.VISIBLE);
                    viewModel.getReceivedTrades();
                }
            }

            @Override
            public void onTabUnselected(TabLayout.Tab tab) {
            }

            @Override
            public void onTabReselected(TabLayout.Tab tab) {
            }
        });
    }


    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
