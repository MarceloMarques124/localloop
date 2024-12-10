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
import androidx.navigation.NavController;
import androidx.navigation.Navigation;

import com.example.localloop.R;
import com.example.localloop.databinding.FragmentAdvertisementBinding;

public class AdvertisementFragment extends Fragment {
    private static final String TAG = "AdvertisementFragment";
    private static final int SWIPE_THRESHOLD = 100;
    private static final int SWIPE_VELOCITY_THRESHOLD = 100;

    private GestureDetector gestureDetector;
    private FragmentAdvertisementBinding binding;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentAdvertisementBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

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


        binding.getRoot().setOnTouchListener((v, event) -> {
            boolean result = gestureDetector.onTouchEvent(event);
            return result;
        });


        // Handle arguments passed via NavController
        if (getArguments() != null) {
            String advertisementId = getArguments().getString("ADVERTISEMENT_ID");
            binding.textViewAdvertisementId.setText(advertisementId);
        }
    }

    private void navigateToHomeFragment(View view) {
        NavController navController = Navigation.findNavController(view);
        navController.navigate(R.id.action_navigation_advertisement_to_navigation_home);
    }
}
