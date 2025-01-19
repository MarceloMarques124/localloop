package com.localloop.ui.proposal;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.LifecycleOwner;
import androidx.lifecycle.ViewModelProvider;

import com.localloop.R;
import com.localloop.databinding.FragmentMakeProposalBinding;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class MakeProposalFragment extends Fragment {
    private FragmentMakeProposalBinding binding;
    private MakeProposalViewModel viewModel;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentMakeProposalBinding.inflate(inflater, container, false);

        viewModel = new ViewModelProvider(this).get(MakeProposalViewModel.class);

        LifecycleOwner viewLifecycleOwner = getViewLifecycleOwner();


        return inflater.inflate(R.layout.fragment_make_proposal, container, false);
    }
}