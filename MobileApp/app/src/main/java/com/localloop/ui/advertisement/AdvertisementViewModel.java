package com.localloop.ui.advertisement;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class AdvertisementViewModel extends ViewModel {

    private final MutableLiveData<String> description;
    private final MutableLiveData<String> title;
    private final MutableLiveData<String> advertisementCreatedDate;
    private final MutableLiveData<Float> rating;
    private final MutableLiveData<String> accountCreatedAt;
    private final MutableLiveData<String> buttonText;

    @Inject
    public AdvertisementViewModel() {
        description = new MutableLiveData<>();
        title = new MutableLiveData<>();
        advertisementCreatedDate = new MutableLiveData<>();
        rating = new MutableLiveData<>();
        accountCreatedAt = new MutableLiveData<>();
        buttonText = new MutableLiveData<>();
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

    public LiveData<String> getAdvertisementCreatedDate() {
        return advertisementCreatedDate;
    }

    public void setAdvertisementCreatedDate(String createdDate) {
        advertisementCreatedDate.setValue(createdDate);
    }

    public LiveData<Float> getRating() {
        return rating;
    }

    public void setRating(Float rating) {
        this.rating.setValue(rating);
    }

    public LiveData<String> getAccountCreatedAt() {
        return accountCreatedAt;
    }

    public void setAccountCreatedAt(String createdDate) {
        accountCreatedAt.setValue(createdDate);
    }

    public LiveData<String> getButtonText() {
        return buttonText;
    }

    public void setButtonText(String text) {
        this.buttonText.setValue(text);
    }
}
