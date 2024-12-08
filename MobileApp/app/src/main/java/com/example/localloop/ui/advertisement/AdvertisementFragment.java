package com.example.localloop.ui.advertisement;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.navigation.NavController;
import androidx.navigation.fragment.NavHostFragment;

import com.example.localloop.databinding.FragmentAdvertisementBinding;

public class AdvertisementFragment extends Fragment {

    private FragmentAdvertisementBinding binding;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentAdvertisementBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        setupToolbar();

        if (getArguments() != null) {
            String advertisementId = getArguments().getString("ADVERTISEMENT_ID");
            binding.textViewAdvertisementId.setText(advertisementId);
        }
    }

    private void setupToolbar() {
        NavController navController = NavHostFragment.findNavController(this);

//        NavigationUI.setupWithNavController(binding.toolbar, navController);
    }
}
