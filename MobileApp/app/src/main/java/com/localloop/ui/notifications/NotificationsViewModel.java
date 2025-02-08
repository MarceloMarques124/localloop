package com.localloop.ui.notifications;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.responses.TradeResponse;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class NotificationsViewModel extends BaseViewModel {

    private final CurrentUserRepository currentUserRepository;
    private final MutableLiveData<List<TradeResponse>> sentTradesLiveData = new MutableLiveData<>();
    private final MutableLiveData<List<TradeResponse>> receivedTradesLiveData = new MutableLiveData<>();

    @Inject
    public NotificationsViewModel(CurrentUserRepository currentUserRepository) {
        this.currentUserRepository = currentUserRepository;
    }

    public LiveData<List<TradeResponse>> getSentTradesLiveData() {
        return sentTradesLiveData;
    }

    public LiveData<List<TradeResponse>> getReceivedTradesLiveData() {
        return receivedTradesLiveData;
    }

    public void getSentTrades() {
        currentUserRepository.getSentTrades(new DataCallBack<>() {
            @Override
            public void onSuccess(List<TradeResponse> sentTrades) {
                sentTradesLiveData.setValue(sentTrades);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void getReceivedTrades() {
        currentUserRepository.getReceivedTrades(new DataCallBack<>() {
            @Override
            public void onSuccess(List<TradeResponse> receivedTrades) {
                receivedTradesLiveData.setValue(receivedTrades);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}
