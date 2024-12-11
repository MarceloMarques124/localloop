package com.example.localloop.ui.advertisement;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class AdvertisementViewModel extends ViewModel {

    private final MutableLiveData<String> mDescription;
    private final MutableLiveData<String> mTitle;
    private final MutableLiveData<String> mCreatedDate;
    private final MutableLiveData<Float> mRating;

    public AdvertisementViewModel() {
        mDescription = new MutableLiveData<>();
        mDescription.setValue("Default advertisement description");

        mTitle = new MutableLiveData<>();
        mTitle.setValue("Default advertisement title");

        mCreatedDate = new MutableLiveData<>();
        mCreatedDate.setValue("Created By User at Date");

        mRating = new MutableLiveData<>();
        mRating.setValue(4.5f);
    }

    public LiveData<String> getDescription() {
        return mDescription;
    }

    public void setDescription(String description) {
        mDescription.setValue(description);
    }

    public LiveData<String> getTitle() {
        return mTitle;
    }

    public void setTitle(String title) {
        mTitle.setValue(title);
    }

    public LiveData<String> getCreatedDate() {
        return mCreatedDate;
    }

    public void setCreatedDate(String createdDate) {
        mCreatedDate.setValue(createdDate);
    }

    public LiveData<Float> getRating() {
        return mRating;
    }

    public void setRating(Float rating) {
        mRating.setValue(rating);
    }

}
