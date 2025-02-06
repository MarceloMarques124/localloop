package com.localloop.ui.profile;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.data.models.User;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class ProfileViewModel extends BaseViewModel {

    private final CurrentUserRepository currentUserRepository;
    private final MutableLiveData<User> userLiveData = new MutableLiveData<>();

    @Inject
    public ProfileViewModel(CurrentUserRepository currentUserRepository) {
        this.currentUserRepository = currentUserRepository;
    }

    public LiveData<User> getUserLiveData() {
        return userLiveData;
    }

    public void getCurrentUser() {
        currentUserRepository.getUser(new DataCallBack<>() {
            @Override
            public void onSuccess(User user) {
                userLiveData.setValue(user);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}