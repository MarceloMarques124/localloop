package com.localloop.ui.proposal;

import com.localloop.ui.BaseViewModel;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class MakeProposalViewModel extends BaseViewModel {
    @Inject
    public MakeProposalViewModel() {
        super();
    }
}
