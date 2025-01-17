package com.localloop.ui.advertisement;

import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.MotionEvent;
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
    private static final int SWIPE_THRESHOLD = 100;
    private static final int SWIPE_VELOCITY_THRESHOLD = 100;
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
            String createdByUser = getString(R.string.CREATED_BY_USER_AT, viewModel.advertisement.getUser().getName(), dtf.format(dateTime));
            binding.createdDate.setText(createdByUser);
        });

        viewModel.getRating().observe(viewLifecycleOwner, binding.userRating::setRating);
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
        GestureDetector gestureDetector;
        super.onViewCreated(view, savedInstanceState);

        List<Integer> images = List.of(
                R.drawable.place_holder_image
        );

        CarouselAdapter adapter = new CarouselAdapter(images);
        binding.viewPagerCarousel.setAdapter(adapter);

        navController = Navigation.findNavController(binding.getRoot());

        gestureDetector = new GestureDetector(requireContext(), new GestureDetector.SimpleOnGestureListener() {
            @Override
            public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX, float velocityY) {
                float diffX = e2.getX() - e1.getX();

                if (Math.abs(diffX) > SWIPE_THRESHOLD && Math.abs(velocityX) > SWIPE_VELOCITY_THRESHOLD) {
                    if (diffX > 0) {
                        navigateToHomeFragment();
                    }
                    return true;
                }
                return false;
            }
        });

        binding.getRoot().setOnTouchListener((v, event) -> gestureDetector.onTouchEvent(event));

        viewModel.setButtonText(getString(R.string.MAKE_PROPOSAL));

        binding.actionButton.setOnClickListener(v -> navigateToMakeProposalFragment());

        viewModel.setRating(3f);
    }

    private void navigateToHomeFragment() {
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_home);
    }

    private void navigateToMakeProposalFragment() {
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_make_proposal);
    }
}
