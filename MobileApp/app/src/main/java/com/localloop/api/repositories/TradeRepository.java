package com.localloop.api.repositories;

import com.localloop.data.models.Trade;
import com.localloop.utils.DataCallBack;

public interface TradeRepository {
    void createTrade(Trade trade, DataCallBack<Trade> callBack);
}
