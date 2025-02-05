package com.localloop.ui.advertisement.create;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

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

        viewModel.getCreatedAdvertisement().observe(getViewLifecycleOwner(), advertisement -> {
            Toast.makeText(getContext(), "Advertisement created successfully!", Toast.LENGTH_SHORT).show();
            // e.g., NavHostFragment.findNavController(this).navigate(R.id.action_createAdvertisementFragment_to_someOtherFragment);
        });

        viewModel.getErrorMessage().observe(getViewLifecycleOwner(), errorMessage -> {
            Toast.makeText(getContext(), errorMessage, Toast.LENGTH_SHORT).show();
            // e.g., NavHostFragment.findNavController(this).navigate(R.id.action_createAdvertisementFragment_to_someOtherFragment);

        });

        binding.btnSubmit.setOnClickListener(v -> onCreateAdvertisement());

        binding.btnCancel.setOnClickListener(v -> onCancelCreateAdvertisement());

        return binding.getRoot();
    }

    private void onCreateAdvertisement() {
        String title = binding.edtTitle.getText().toString();
        String description = binding.edtDescription.getText().toString();
        boolean isService = binding.rbService.isChecked();
        String imagePath = "";

        if (title.isEmpty() || description.isEmpty()) {
            Toast.makeText(getContext(), "Please fill all fields.", Toast.LENGTH_SHORT).show();
            return;
        }

        viewModel.createAdvertisement(title, description, isService, imagePath);
    }

    private void onCancelCreateAdvertisement() {
        Toast.makeText(getContext(), "Advertisement creation canceled.", Toast.LENGTH_SHORT).show();
        binding.edtTitle.setText("");
        binding.edtDescription.setText("");
        binding.radioGroup.clearCheck();
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
