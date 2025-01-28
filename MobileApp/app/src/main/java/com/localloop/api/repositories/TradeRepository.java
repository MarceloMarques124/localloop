package com.localloop.api.repositories;

import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Trade;
import com.localloop.utils.DataCallBack;

public interface TradeRepository {
    void initTrade(InitTradeRequest trade, DataCallBack<Trade> callBack);
}
