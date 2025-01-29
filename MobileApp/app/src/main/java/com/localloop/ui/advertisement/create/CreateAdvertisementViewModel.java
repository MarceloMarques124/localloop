package com.localloop.ui.advertisement.create;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.ui.BaseViewModel;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class CreateAdvertisementViewModel extends BaseViewModel {
    private final AdvertisementRepository advertisementRepository;

    @Inject
    public CreateAdvertisementViewModel(AdvertisementRepository advertisementRepository) {
        this.advertisementRepository = advertisementRepository;
    }
}