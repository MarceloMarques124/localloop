package com.localloop.api.repositories;

import com.localloop.api.requests.AddProposalRequest;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Trade;
import com.localloop.utils.DataCallBack;

public interface TradeRepository {
    void initTrade(InitTradeRequest trade, DataCallBack<Trade> callBack);

    void getTrade(int id, DataCallBack<Trade> callBack);

    void addProposal(int tradeId, AddProposalRequest addProposalRequest, DataCallBack<Trade> callBack);
}
