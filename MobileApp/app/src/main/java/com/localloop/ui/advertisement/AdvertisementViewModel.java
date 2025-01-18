package com.localloop.ui.advertisement;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.time.LocalDateTime;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class AdvertisementViewModel extends ViewModel {

    private final MutableLiveData<String> description;
    private final MutableLiveData<String> title;
    private final MutableLiveData<LocalDateTime> advertisementCreatedDate;
    private final MutableLiveData<Float> rating;
    private final MutableLiveData<LocalDateTime> accountCreatedAt;
    private final MutableLiveData<String> buttonText;
    private final MutableLiveData<String> error;
    private final AdvertisementRepository advertisementRepository;
    public Advertisement advertisement;

    @Inject
    public AdvertisementViewModel(AdvertisementRepository advertisementRepository) {
        this.advertisementRepository = advertisementRepository;

        description = new MutableLiveData<>();
        title = new MutableLiveData<>();
        advertisementCreatedDate = new MutableLiveData<>();
        rating = new MutableLiveData<>();
        accountCreatedAt = new MutableLiveData<>();
        buttonText = new MutableLiveData<>();
        error = new MutableLiveData<>();
    }

    public void getAdvertisement(int id) {
        advertisementRepository.getAdvertisement(id, new DataCallBack<>() {
            @Override
            public void onSuccess(Advertisement advertisement) {
                updateData(advertisement);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    private void updateData(Advertisement advertisement) {
        setAdvertisement(advertisement);

        description.setValue(advertisement.getDescription());
        title.setValue(advertisement.getTitle());
        advertisementCreatedDate.setValue(advertisement.getCreatedAt());
        rating.setValue(advertisement.getUser().getAverageStars());
        accountCreatedAt.setValue(advertisement.getUser().getCreatedAt());
        // buttonText =
    }

    public Advertisement getAdvertisement() {
        return advertisement;
    }

    public void setAdvertisement(Advertisement advertisement) {
        this.advertisement = advertisement;
    }

    public LiveData<String> getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description.setValue(description);
    }

    public LiveData<String> getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title.setValue(title);
    }

    public LiveData<LocalDateTime> getAdvertisementCreatedDate() {
        return advertisementCreatedDate;
    }

    public void setAdvertisementCreatedDate(LocalDateTime createdDate) {
        advertisementCreatedDate.setValue(createdDate);
    }

    public LiveData<Float> getRating() {
        return rating;
    }

    public void setRating(Float rating) {
        this.rating.setValue(rating);
    }

    public LiveData<LocalDateTime> getAccountCreatedAt() {
        return accountCreatedAt;
    }

    public void setAccountCreatedAt(LocalDateTime createdDate) {
        accountCreatedAt.setValue(createdDate);
    }

    public LiveData<String> getButtonText() {
        return buttonText;
    }

    public void setButtonText(String text) {
        this.buttonText.setValue(text);
    }

    public LiveData<String> getError() {
        return error;
    }
}
