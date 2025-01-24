package com.localloop.api.services;

import com.localloop.data.models.Trade;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface TradeApiService {
    @POST("trades")
    Call<Trade> createTrade(@Body Trade trade);
}
