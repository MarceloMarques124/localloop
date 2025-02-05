package com.localloop.ui.advertisement.create;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class CreateAdvertisementViewModel extends BaseViewModel {

    private final AdvertisementRepository advertisementRepository;
    private final MutableLiveData<Advertisement> createdAdvertisement = new MutableLiveData<>();
    private final MutableLiveData<String> errorMessage = new MutableLiveData<>();

    @Inject
    public CreateAdvertisementViewModel(AdvertisementRepository advertisementRepository) {
        this.advertisementRepository = advertisementRepository;
    }

    public LiveData<Advertisement> getCreatedAdvertisement() {
        return createdAdvertisement;
    }

    public LiveData<String> getErrorMessage() {
        return errorMessage;
    }

    public void createAdvertisement(String title, String description, boolean isService, String imagePath) {
        Advertisement advertisement = new Advertisement(title, description, isService);

        advertisementRepository.createAdvertisement(advertisement, new DataCallBack<>() {
            @Override
            public void onSuccess(Advertisement data) {
                createdAdvertisement.setValue(data);
            }

            @Override
            public void onError(String error) {
                errorMessage.setValue(error);
            }
        });
    }
}
