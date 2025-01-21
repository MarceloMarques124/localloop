package com.localloop.ui.home;

import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.data.models.SavedAdvertisement;
import com.localloop.databinding.FragmentHomeBinding;

import dagger.hilt.android.AndroidEntryPoint;


@AndroidEntryPoint
public class HomeFragment extends Fragment {

    private FragmentHomeBinding binding;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentHomeBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        HomeViewModel homeViewModel = new ViewModelProvider(this).get(HomeViewModel.class);

        RecyclerView recyclerView = binding.recyclerView;
        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2));

        homeViewModel.getAdvertisements().observe(getViewLifecycleOwner(), advertisements -> {
            if (advertisements != null) {
                recyclerView.setAdapter(new CardAdapter(advertisements, advertisement -> {
                    SavedAdvertisement savedAdvertisement = new SavedAdvertisement();
                    savedAdvertisement.setAdvertisementId(savedAdvertisement.getAdvertisementId()); // Set the advertisement ID
                    homeViewModel.insertSavedAdvertisement(savedAdvertisement); // Call the method to save the advertisement
                }));
            }
        });


        homeViewModel.getError().observe(getViewLifecycleOwner(), errorMessage -> {
            if (errorMessage != null) {
                Log.e("API Failure", errorMessage);
                showErrorPopup(getContext(), errorMessage);
            }
        });

        return root;
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
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
