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
import com.localloop.data.models.User;
import com.localloop.databinding.FragmentNotificationsBinding;

import java.util.ArrayList;
import java.util.List;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class NotificationsFragment extends Fragment {

    private final List<User> messagesList = new ArrayList<>();
    private final List<User> notificationsList = new ArrayList<>();
    private FragmentNotificationsBinding binding;
    private NotificationsViewModel notificationsViewModel;
    private TradePartnersAdapter adapter;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        notificationsViewModel = new ViewModelProvider(this).get(NotificationsViewModel.class);
        binding = FragmentNotificationsBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        setupRecyclerViews();
        setupTabLayout();

        // Observe the trade partners (or any data source)
        notificationsViewModel.getTradePartners().observe(getViewLifecycleOwner(), tradePartners -> {
            if (tradePartners != null) {
                messagesList.clear();
                messagesList.addAll(tradePartners);
                adapter.notifyDataSetChanged();
            }
        });

        return root;
    }

    private void setupRecyclerViews() {
        // Set up RecyclerViews with the same adapter
        adapter = new TradePartnersAdapter(messagesList); // Initially using messagesList

        binding.recyclerViewMessages.setLayoutManager(new LinearLayoutManager(getContext()));
        binding.recyclerViewMessages.setAdapter(adapter);

        binding.recyclerViewNotifications.setLayoutManager(new LinearLayoutManager(getContext()));
        binding.recyclerViewNotifications.setAdapter(adapter);

        // Initially, show messages and hide notifications
        binding.recyclerViewMessages.setVisibility(View.VISIBLE);
        binding.recyclerViewNotifications.setVisibility(View.GONE);
    }

    private void setupTabLayout() {
        // Add tabs manually
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Messages"));
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Notifications"));

        binding.tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                if (tab.getPosition() == 0) {
                    binding.recyclerViewMessages.setVisibility(View.VISIBLE);
                    binding.recyclerViewNotifications.setVisibility(View.GONE);
                    adapter.updateList(messagesList);
                } else {
                    binding.recyclerViewMessages.setVisibility(View.GONE);
                    binding.recyclerViewNotifications.setVisibility(View.VISIBLE);
                    adapter.updateList(notificationsList);
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
