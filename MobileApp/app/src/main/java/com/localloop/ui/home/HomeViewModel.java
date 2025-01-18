package com.localloop.ui.home;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class HomeViewModel extends BaseViewModel {

    private final MutableLiveData<List<Advertisement>> advertisements;
    private final AdvertisementRepository advertisementRepository;

    @Inject
    public HomeViewModel(AdvertisementRepository advertisementRepository) {
        this.advertisementRepository = advertisementRepository;
        advertisements = new MutableLiveData<>();
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
}
