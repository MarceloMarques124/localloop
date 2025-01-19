package com.localloop.ui.advertisement;

import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.LifecycleOwner;
import androidx.lifecycle.ViewModelProvider;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;

import com.localloop.R;
import com.localloop.databinding.FragmentAdvertisementBinding;

import java.time.format.DateTimeFormatter;
import java.util.List;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class AdvertisementFragment extends Fragment {
    private FragmentAdvertisementBinding binding;
    private AdvertisementViewModel viewModel;
    private NavController navController;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentAdvertisementBinding.inflate(inflater, container, false);

        viewModel = new ViewModelProvider(this).get(AdvertisementViewModel.class);

        LifecycleOwner viewLifecycleOwner = getViewLifecycleOwner();

        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm dd/MM/yyyy");
        DateTimeFormatter dtfDateOnly = DateTimeFormatter.ofPattern("dd/MM/yyyy");

        viewModel.getDescription().observe(viewLifecycleOwner, binding.descriptionText::setText);
        viewModel.getTitle().observe(viewLifecycleOwner, binding.advertisementName::setText);

        viewModel.getAdvertisementCreatedDate().observe(viewLifecycleOwner, dateTime -> {
            String createdByUser = getString(R.string.CREATED_BY_USER_AT, viewModel.getAdvertisement().getUser().getName(), dtf.format(dateTime));
            binding.createdDate.setText(createdByUser);
        });

        viewModel.getRating().observe(viewLifecycleOwner, rating -> {
            if (rating == 0) {
                binding.userRating.setVisibility(View.GONE);
                binding.noReviewsText.setVisibility(View.VISIBLE);
            } else {
                binding.userRating.setVisibility(View.VISIBLE);
                binding.noReviewsText.setVisibility(View.GONE);
                binding.userRating.setRating(rating);
            }
        });

        viewModel.getButtonText().observe(viewLifecycleOwner, binding.actionButton::setText);

        viewModel.getAccountCreatedAt().observe(viewLifecycleOwner, dateTime -> {
            String accountCreatedAt = getString(R.string.ACCOUNT_CREATED_IN, dtfDateOnly.format(dateTime));
            binding.accountCreated.setText(accountCreatedAt);
        });

        viewModel.getError().observe(getViewLifecycleOwner(), errorMessage -> {
            if (errorMessage != null) {
                Log.e("API Failure", errorMessage);
                showErrorPopup(getContext(), errorMessage);
            }
        });

        var arguments = getArguments();
        if (arguments != null) {
            String value = arguments.getString("ADVERTISEMENT_ID");
            if (value != null) {
                int advertisementId = Integer.parseInt(value);
                viewModel.getAdvertisement(advertisementId);
            }
        }

        return binding.getRoot();
    }

    private void showErrorPopup(Context context, String errorMessage) {
        new AlertDialog.Builder(context)
                .setTitle("Error")
                .setMessage(errorMessage)
                .setPositiveButton("OK", (dialog, which) -> dialog.dismiss())
                .create()
                .show();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        List<Integer> images = List.of(
                R.drawable.place_holder_image
        );

        CarouselAdapter adapter = new CarouselAdapter(images);
        binding.viewPagerCarousel.setAdapter(adapter);

        navController = Navigation.findNavController(binding.getRoot());

        viewModel.setButtonText(getString(R.string.MAKE_PROPOSAL));

        binding.actionButton.setOnClickListener(v -> navigateToMakeProposalFragment(viewModel.getAdvertisement().getId()));
    }

    private void navigateToMakeProposalFragment(int id) {
        Bundle args = new Bundle();
        args.putString("ADVERTISEMENT_ID", String.valueOf(id));

        navController.navigate(R.id.action_navigation_advertisement_to_navigation_make_proposal, args);
    }
}
