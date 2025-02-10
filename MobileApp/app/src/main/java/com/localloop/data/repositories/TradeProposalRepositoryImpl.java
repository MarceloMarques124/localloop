package com.localloop.data.repositories;

import com.localloop.api.repositories.TradeProposalRepository;
import com.localloop.api.services.TradeProposalApiService;
import com.localloop.data.models.TradeProposal;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

public class TradeProposalRepositoryImpl extends BaseRepositoryImpl implements TradeProposalRepository {

    private final TradeProposalApiService apiService;

    @Inject
    public TradeProposalRepositoryImpl(TradeProposalApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void updateStatus(int tradeProposalId, int state, DataCallBack<TradeProposal> callBack) {
        enqueueCall(apiService.updateTradeProposalStatus(tradeProposalId, state), callBack, "Failed to update trade proposal status");
    }

    @Override
    public void acceptTradeProposal(int tradeProposalId, DataCallBack<TradeProposal> callBack) {
        enqueueCall(apiService.acceptTradeProposal(tradeProposalId), callBack, "Failed to accept the trade");
    }
}
