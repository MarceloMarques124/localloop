package com.localloop.api.services;

import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Trade;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface TradeApiService {
    @POST("trades")
    Call<Trade> initTrade(@Body InitTradeRequest trade);
}
