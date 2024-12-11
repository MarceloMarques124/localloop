package com.example.localloop.ui.advertisement;

import android.os.Bundle;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;

import com.example.localloop.R;
import com.example.localloop.databinding.FragmentAdvertisementBinding;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

public class AdvertisementFragment extends Fragment {
    private static final int SWIPE_THRESHOLD = 100;
    private static final int SWIPE_VELOCITY_THRESHOLD = 100;

    private GestureDetector gestureDetector;
    private FragmentAdvertisementBinding binding;
    private AdvertisementViewModel advertisementViewModel;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentAdvertisementBinding.inflate(inflater, container, false);

        advertisementViewModel = new ViewModelProvider(this).get(AdvertisementViewModel.class);

        advertisementViewModel.getDescription().observe(getViewLifecycleOwner(), description -> binding.descriptionText.setText(description));
        advertisementViewModel.getTitle().observe(getViewLifecycleOwner(), title -> binding.advertisementName.setText(title));
        advertisementViewModel.getCreatedDate().observe(getViewLifecycleOwner(), createdDate -> binding.createdDate.setText(createdDate));
        advertisementViewModel.getRating().observe(getViewLifecycleOwner(), rating -> binding.userRating.setRating(rating));

        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        List<Integer> images = List.of(
                R.drawable.place_holder_image
        );

        CarouselAdapter adapter = new CarouselAdapter(images);
        binding.viewPagerCarousel.setAdapter(adapter);

        gestureDetector = new GestureDetector(requireContext(), new GestureDetector.SimpleOnGestureListener() {
            @Override
            public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX, float velocityY) {
                float diffX = e2.getX() - e1.getX();

                if (Math.abs(diffX) > SWIPE_THRESHOLD && Math.abs(velocityX) > SWIPE_VELOCITY_THRESHOLD) {
                    if (diffX > 0) {
                        navigateToHomeFragment(binding.getRoot());
                    }
                    return true;
                }
                return false;
            }

            @Override
            public boolean onDown(MotionEvent e) {
                return true;
            }
        });

        binding.getRoot().setOnTouchListener((v, event) -> gestureDetector.onTouchEvent(event));

        if (getArguments() != null) {
            String advertisementId = getArguments().getString("ADVERTISEMENT_ID");

            String advertisementDescription = "Description for advertisement with ID: " + advertisementId;
            String advertisementName = "Advertisement " + advertisementId;

            DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm dd/MM/yyyy");
            LocalDateTime now = LocalDateTime.now();

            advertisementViewModel.setDescription(advertisementDescription);
            advertisementViewModel.setTitle(advertisementName);

            String createdByUser = getString(R.string.CREATED_BY_USER_AT, "Marcelo", dtf.format(now));

            advertisementViewModel.setCreatedDate(createdByUser);
            advertisementViewModel.setRating(3f);
        }
    }

    private void navigateToHomeFragment(View view) {
        NavController navController = Navigation.findNavController(view);
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_home);
    }
}
