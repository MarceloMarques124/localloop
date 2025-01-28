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

import com.localloop.R;
import com.localloop.databinding.FragmentAdvertisementBinding;
import com.localloop.ui.proposal.MakeProposalDrawer;
import com.localloop.utils.ArgumentKeys;

import java.time.format.DateTimeFormatter;
import java.util.List;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class AdvertisementFragment extends Fragment {
    private FragmentAdvertisementBinding binding;
    private AdvertisementViewModel viewModel;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentAdvertisementBinding.inflate(inflater, container, false);

        viewModel = new ViewModelProvider(this).get(AdvertisementViewModel.class);

        getParentFragmentManager().setFragmentResultListener(ArgumentKeys.PROPOSAL_SENT, getViewLifecycleOwner(), (requestKey, result) -> {
            boolean proposalSent = result.getBoolean(ArgumentKeys.PROPOSAL_SENT, false);
            if (proposalSent) {
                viewModel.setHasProposal(true);
            }
        });

        LifecycleOwner viewLifecycleOwner = getViewLifecycleOwner();

        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm dd/MM/yyyy");
        DateTimeFormatter dtfDateOnly = DateTimeFormatter.ofPattern("dd/MM/yyyy");

        viewModel.getHasProposal().observe(viewLifecycleOwner, value -> {
            if (Boolean.TRUE.equals(viewModel.getHasProposal().getValue())) {
                viewModel.setButtonText(getString(R.string.VIEW_YOUR_PROPOSAL));
            } else {
                viewModel.setButtonText(getString(R.string.MAKE_PROPOSAL));
            }
        });

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
            String value = arguments.getString(ArgumentKeys.ADVERTISEMENT_ID);
            if (value != null) {
                int advertisementId = Integer.parseInt(value);
                viewModel.getAdvertisement(advertisementId);
            }
        }

        return binding.getRoot();
    }

    private void showErrorPopup(Context context, String errorMessage) {
        new AlertDialog.Builder(context)
                .setTitle(getString(R.string.ERROR))
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

        binding.actionButton.setOnClickListener(v -> {
            Bundle args = new Bundle();
            args.putInt(ArgumentKeys.ADVERTISEMENT_ID, viewModel.getAdvertisement().getId());

            if (Boolean.TRUE.equals(viewModel.getHasProposal().getValue())) {

            } else {
                MakeProposalDrawer makeProposalDrawer = new MakeProposalDrawer();
                makeProposalDrawer.setArguments(args);
                makeProposalDrawer.show(getParentFragmentManager(), makeProposalDrawer.getTag());
            }
        });
    }
}
