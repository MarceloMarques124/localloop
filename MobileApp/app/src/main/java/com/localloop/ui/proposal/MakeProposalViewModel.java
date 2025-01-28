package com.localloop.ui.proposal;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Advertisement;
import com.localloop.data.models.Item;
import com.localloop.data.models.Trade;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class MakeProposalViewModel extends BaseViewModel {

    private final CurrentUserRepository currentUserRepository;
    private final TradeRepository tradeRepository;
    private final MutableLiveData<Trade> createdTrade = new MutableLiveData<>();
    private final MutableLiveData<List<Item>> currentUserItems = new MutableLiveData<>();
    private final MutableLiveData<Advertisement> advertisementMutableLiveData = new MutableLiveData<>();


    @Inject
    public MakeProposalViewModel(CurrentUserRepository currentUserRepository, TradeRepository tradeRepository) {
        this.currentUserRepository = currentUserRepository;
        this.tradeRepository = tradeRepository;
    }

    public LiveData<List<Item>> getItems() {
        return currentUserItems;
    }

    public LiveData<Trade> getCreatedTrade() {
        return createdTrade;
    }

    public LiveData<Advertisement> getAdvertisement() {
        return advertisementMutableLiveData;
    }

    public void fetchCurrentUserItems() {
        currentUserRepository.fetchItems(new DataCallBack<>() {
            @Override
            public void onSuccess(List<Item> data) {
                currentUserItems.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void initTrade(InitTradeRequest initTradeRequest) {
        tradeRepository.initTrade(initTradeRequest, new DataCallBack<Trade>() {
            @Override
            public void onSuccess(Trade data) {
                createdTrade.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}
