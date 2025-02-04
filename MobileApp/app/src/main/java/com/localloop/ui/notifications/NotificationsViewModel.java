package com.localloop.ui.notifications;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.data.models.User;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class NotificationsViewModel extends BaseViewModel {

    private final CurrentUserRepository currentUserRepository;
    private final MutableLiveData<List<User>> tradePartners = new MutableLiveData<>();

    @Inject
    public NotificationsViewModel(CurrentUserRepository currentUserRepository) {
        this.currentUserRepository = currentUserRepository;
        loadTradePartners();
    }

    private void loadTradePartners() {
        currentUserRepository.getTradePartners(new DataCallBack<>() {
            @Override
            public void onSuccess(List<User> data) {
                tradePartners.postValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.postValue(errorMessage);
            }
        });
    }

    public LiveData<List<User>> getTradePartners() {
        return tradePartners;
    }
}
