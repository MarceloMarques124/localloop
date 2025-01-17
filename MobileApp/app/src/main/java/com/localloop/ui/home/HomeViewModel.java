package com.localloop.ui.home;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class HomeViewModel extends ViewModel {

    private final MutableLiveData<List<Advertisement>> advertisements;
    private final MutableLiveData<String> error;
    private final AdvertisementRepository advertisementRepository;

    @Inject
    public HomeViewModel(AdvertisementRepository advertisementRepository) {
        this.advertisementRepository = advertisementRepository;
        advertisements = new MutableLiveData<>();
        error = new MutableLiveData<>();
        loadAdvertisements();
    }

    private void loadAdvertisements() {
        advertisementRepository.getAdvertisements(new DataCallBack<>() {
            @Override
            public void onSuccess(List<Advertisement> data) {
                advertisements.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public LiveData<List<Advertisement>> getAdvertisements() {
        return advertisements;
    }

    public LiveData<String> getError() {
        return error;
    }
}
