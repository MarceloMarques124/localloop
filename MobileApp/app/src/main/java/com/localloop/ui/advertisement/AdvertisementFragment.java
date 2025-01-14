package com.localloop.ui.advertisement;

import android.os.Bundle;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.LifecycleOwner;
import androidx.lifecycle.ViewModelProvider;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;

import com.localloop.R;
import com.localloop.databinding.FragmentAdvertisementBinding;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

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

        viewModel.getDescription().observe(viewLifecycleOwner, binding.descriptionText::setText);
        viewModel.getTitle().observe(viewLifecycleOwner, binding.advertisementName::setText);
        viewModel.getAdvertisementCreatedDate().observe(viewLifecycleOwner, binding.createdDate::setText);
        viewModel.getRating().observe(viewLifecycleOwner, binding.userRating::setRating);
        viewModel.getButtonText().observe(viewLifecycleOwner, binding.actionButton::setText);
        viewModel.getAccountCreatedAt().observe(viewLifecycleOwner, binding.accountCreated::setText);

        return binding.getRoot();
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

        if (getArguments() == null) {
            return;
        }

        viewModel.setButtonText(getString(R.string.MAKE_PROPOSAL));

        binding.actionButton.setOnClickListener(v -> navigateToMakeProposalFragment());

        String advertisementId = getArguments().getString("ADVERTISEMENT_ID");

        String advertisementDescription = "Description for advertisement with ID: " + advertisementId;
        String advertisementName = "Advertisement " + advertisementId;

        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm dd/MM/yyyy");
        DateTimeFormatter dtfDateOnly = DateTimeFormatter.ofPattern("dd/MM/yyyy");
        LocalDateTime now = LocalDateTime.now();

        viewModel.setDescription(advertisementDescription);
        viewModel.setTitle(advertisementName);

        String createdByUser = getString(R.string.CREATED_BY_USER_AT, "Marcelo", dtf.format(now));

        viewModel.setAdvertisementCreatedDate(createdByUser);
        viewModel.setRating(3f);

        String accountCreatedAt = getString(R.string.ACCOUNT_CREATED_IN, dtfDateOnly.format(now));

        viewModel.setAccountCreatedAt(accountCreatedAt);
    }

    private void navigateToHomeFragment() {
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_home);
    }

    private void navigateToMakeProposalFragment() {
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_make_proposal);
    }
}
