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

import java.util.ArrayList;
import java.util.List;

public class HomeFragment extends Fragment {

    private FragmentHomeBinding binding;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        HomeViewModel homeViewModel =
                new ViewModelProvider(this).get(HomeViewModel.class);

        binding = FragmentHomeBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

//        final TextView textView = binding.textHome;
//        homeViewModel.getText().observe(getViewLifecycleOwner(), textView::setText);

        RecyclerView recyclerView = binding.recyclerView;
        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2));
        recyclerView.setAdapter(new CardAdapter(getCardData()));

        return root;
    }

    private List<String> getCardData() {
        List<String> data = new ArrayList<>();
        data.add("Card 1");
        data.add("Card 2");
        data.add("Card 3");
        data.add("Card 4");
        data.add("Card 5");
        data.add("Card 6");
        data.add("Card 7");
        data.add("Card 8");
        data.add("Card 9");
        data.add("Card 10");
        data.add("Card 11");
        data.add("Card 12");
        data.add("Card 14");
        data.add("Card 15");
        data.add("Card 16");
        data.add("Card 17");
        data.add("Card 18");
        data.add("Card 19");
        data.add("Card 20");

        data.add("Card 1");
        data.add("Card 2");
        data.add("Card 3");
        data.add("Card 4");
        data.add("Card 5");
        data.add("Card 6");
        data.add("Card 7");
        data.add("Card 8");
        data.add("Card 9");
        data.add("Card 10");
        data.add("Card 11");
        data.add("Card 12");
        data.add("Card 14");
        data.add("Card 15");
        data.add("Card 16");
        data.add("Card 17");
        data.add("Card 18");
        data.add("Card 19");
        data.add("Card 20");

        data.add("Card 1");
        data.add("Card 2");
        data.add("Card 3");
        data.add("Card 4");
        data.add("Card 5");
        data.add("Card 6");
        data.add("Card 7");
        data.add("Card 8");
        data.add("Card 9");
        data.add("Card 10");
        data.add("Card 11");
        data.add("Card 12");
        data.add("Card 14");
        data.add("Card 15");
        data.add("Card 16");
        data.add("Card 17");
        data.add("Card 18");
        data.add("Card 19");
        data.add("Card 20");

        return data;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}