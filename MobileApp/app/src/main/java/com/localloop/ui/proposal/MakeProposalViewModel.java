package com.localloop.ui.proposal;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.ItemRepository;
import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.requests.AddProposalRequest;
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
    private final ItemRepository itemRepository;
    private final MutableLiveData<Trade> tradeMutableLiveData = new MutableLiveData<>();
    private final MutableLiveData<List<Item>> itemsLiveData = new MutableLiveData<>();
    private final MutableLiveData<Advertisement> advertisementMutableLiveData = new MutableLiveData<>();


    @Inject
    public MakeProposalViewModel(CurrentUserRepository currentUserRepository, TradeRepository tradeRepository, ItemRepository itemRepository) {
        this.currentUserRepository = currentUserRepository;
        this.tradeRepository = tradeRepository;
        this.itemRepository = itemRepository;
    }

    public LiveData<List<Item>> getItemsLiveData() {
        return itemsLiveData;
    }

    public LiveData<Trade> getTradeMutableLiveData() {
        return tradeMutableLiveData;
    }

    public LiveData<Advertisement> getAdvertisement() {
        return advertisementMutableLiveData;
    }

    public void fetchCurrentUserItems() {
        currentUserRepository.fetchItems(new DataCallBack<>() {
            @Override
            public void onSuccess(List<Item> data) {
                itemsLiveData.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void getUserItems(int userId) {
        itemRepository.getItems(userId, new DataCallBack<>() {
            @Override
            public void onSuccess(List<Item> data) {
                itemsLiveData.setValue(data);
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
                tradeMutableLiveData.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void addProposal(int tradeId, AddProposalRequest addProposalRequest) {
        tradeRepository.addProposal(tradeId, addProposalRequest, new DataCallBack<>() {
            @Override
            public void onSuccess(Trade data) {
                tradeMutableLiveData.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}
