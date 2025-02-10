package com.localloop.ui.profile;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.responses.UserProfile;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.SecureStorage;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class ProfileViewModel extends BaseViewModel {

    private final CurrentUserRepository currentUserRepository;
    private final SecureStorage secureStorage;
    private final MutableLiveData<UserProfile> userLiveData = new MutableLiveData<>();

    @Inject
    public ProfileViewModel(CurrentUserRepository currentUserRepository, SecureStorage secureStorage) {
        this.currentUserRepository = currentUserRepository;
        this.secureStorage = secureStorage;
    }

    public LiveData<UserProfile> getUserProfileLiveData() {
        return userLiveData;
    }

    public void getCurrentUserProfile() {
        currentUserRepository.getUserProfile(new DataCallBack<>() {
            @Override
            public void onSuccess(UserProfile user) {
                userLiveData.setValue(user);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void signOut() {
        secureStorage.removeAuthKey();
    }
}