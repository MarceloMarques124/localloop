package com.localloop.data.repositories;

import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.requests.AddProposalRequest;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.api.services.TradeApiService;
import com.localloop.data.models.Trade;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

public class TradeRepositoryImpl extends BaseRepositoryImpl implements TradeRepository {
    private final TradeApiService apiService;

    @Inject
    public TradeRepositoryImpl(TradeApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void initTrade(InitTradeRequest trade, DataCallBack<Trade> callBack) {
        enqueueCall(apiService.initTrade(trade), callBack, "Failed to save Trades");
    }

    @Override
    public void getTrade(int id, DataCallBack<Trade> callBack) {
        enqueueCall(apiService.getTrade(id), callBack, "Failed to get the trade");
    }

    @Override
    public void addProposal(int tradeId, AddProposalRequest addProposalRequest, DataCallBack<Trade> callBack) {
        enqueueCall(apiService.addProposal(tradeId, addProposalRequest), callBack, "Failed to Add the proposal");
    }
}
