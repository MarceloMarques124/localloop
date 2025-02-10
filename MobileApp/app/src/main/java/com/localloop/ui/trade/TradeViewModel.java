package com.localloop.ui.trade;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.TradeProposalRepository;
import com.localloop.api.repositories.TradeRepository;
import com.localloop.data.models.Trade;
import com.localloop.data.models.TradeProposal;
import com.localloop.data.models.User;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class TradeViewModel extends BaseViewModel {
    private final TradeRepository tradeRepository;
    private final TradeProposalRepository tradeProposalRepository;
    private final CurrentUserRepository currentUserRepository;
    private final MutableLiveData<Trade> tradeMutableLiveData = new MutableLiveData<>();
    private final MutableLiveData<TradeProposal> tradeProposalMutableLiveData = new MutableLiveData<>();
    private final MutableLiveData<User> userMutableLiveData = new MutableLiveData<>();

    @Inject
    public TradeViewModel(TradeRepository tradeRepository, TradeProposalRepository tradeProposalRepository, CurrentUserRepository currentUserRepository) {
        this.tradeRepository = tradeRepository;
        this.tradeProposalRepository = tradeProposalRepository;
        this.currentUserRepository = currentUserRepository;
    }

    public void getTrade(int tradeId) {
        tradeRepository.getTrade(tradeId, new DataCallBack<>() {
            @Override
            public void onSuccess(Trade trade) {
                tradeMutableLiveData.setValue(trade);
                getCurrentUser();
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void acceptTrade(int tradeProposalId) {
        tradeProposalRepository.acceptTradeProposal(tradeProposalId, new DataCallBack<>() {
            @Override
            public void onSuccess(TradeProposal tradeProposal) {
                tradeProposalMutableLiveData.setValue(tradeProposal);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    private void getCurrentUser() {
        currentUserRepository.getUser(new DataCallBack<User>() {
            @Override
            public void onSuccess(User user) {
                userMutableLiveData.setValue(user);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void rejectTradeProposal(int tradeProposalId) {
        tradeProposalRepository.updateStatus(tradeProposalId, TradeProposal.State.REJECTED.getValue(), new DataCallBack<>() {
            @Override
            public void onSuccess(TradeProposal tradeProposal) {
                tradeProposalMutableLiveData.setValue(tradeProposal);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public LiveData<Trade> getTradeLiveData() {
        return tradeMutableLiveData;
    }

    public LiveData<User> getUserLiveData() {
        return userMutableLiveData;
    }

    public LiveData<TradeProposal> getTradeProposalMutableLiveData() {
        return tradeProposalMutableLiveData;
    }
}