package com.example.localloop.ui.home;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.localloop.databinding.FragmentHomeBinding;
import com.example.localloop.models.Advertisement;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class HomeFragment extends Fragment {

    private FragmentHomeBinding binding;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        HomeViewModel homeViewModel =
                new ViewModelProvider(this).get(HomeViewModel.class);

        binding = FragmentHomeBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        RecyclerView recyclerView = binding.recyclerView;
        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2));
        recyclerView.setAdapter(new CardAdapter(getCardData(), getParentFragmentManager()));

        return root;
    }

    private List<Advertisement> getCardData() {
        List<Advertisement> data = new ArrayList<>();
        Random random = new Random();

        for (int i = 1; i <= 20; i++) {
            Advertisement ad = new Advertisement();
            ad.setId(i);
            ad.setUserId(random.nextInt(1000) + 1);
            ad.setDescription("Sample Description " + i);
            ad.setService(random.nextBoolean());
            ad.setCreatedDate(LocalDateTime.now().minusDays(random.nextInt(30)));

            data.add(ad);
        }

        return data;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}