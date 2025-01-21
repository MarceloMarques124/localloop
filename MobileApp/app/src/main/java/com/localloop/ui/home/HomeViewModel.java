package com.localloop.ui.home;

import android.util.Log;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.data.models.SavedAdvertisement;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;


@HiltViewModel
public class HomeViewModel extends BaseViewModel {

    private final MutableLiveData<List<Advertisement>> advertisements;
    private final AdvertisementRepository advertisementRepository;
    private final SavedAdvertisementRepository savedAdvertisementRepository;

    @Inject
    public HomeViewModel(AdvertisementRepository advertisementRepository,
                         SavedAdvertisementRepository savedAdvertisementRepository) {
        this.advertisementRepository = advertisementRepository;
        this.savedAdvertisementRepository = savedAdvertisementRepository;
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

    public void insertSavedAdvertisement(SavedAdvertisement savedAdvertisement) {
        savedAdvertisementRepository.insertSavedAdvertisement(savedAdvertisement.getAdvertisementId(), new DataCallBack<>() {
            @Override
            public void onSuccess(SavedAdvertisement data) {
                Log.d("Save Success", "Advertisement saved");
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
