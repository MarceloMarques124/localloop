package com.localloop.ui.advertisement.create;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.localloop.databinding.FragmentCreateAdvertisementBinding;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class CreateAdvertisementFragment extends Fragment {

    private CreateAdvertisementViewModel viewModel;
    private FragmentCreateAdvertisementBinding binding;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentCreateAdvertisementBinding.inflate(inflater, container, false);

        viewModel = new ViewModelProvider(this).get(CreateAdvertisementViewModel.class);

        return binding.getRoot();
    }
}