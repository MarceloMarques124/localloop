package com.localloop.api.repositories;

import com.localloop.data.models.TradeProposal;
import com.localloop.utils.DataCallBack;

public interface TradeProposalRepository {
    void updateStatus(int tradeProposalId, int state, DataCallBack<TradeProposal> callBack);

    void acceptTradeProposal(int tradeProposalId, DataCallBack<TradeProposal> callBack);
}
