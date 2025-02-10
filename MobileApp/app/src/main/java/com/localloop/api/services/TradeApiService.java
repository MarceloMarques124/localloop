package com.localloop.api.services;

import com.localloop.api.requests.AddProposalRequest;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.data.models.Trade;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface TradeApiService {
    @POST("trades")
    Call<Trade> initTrade(@Body InitTradeRequest trade);

    @GET("trades/{id}")
    Call<Trade> getTrade(@Path("id") int id);

    @POST("trades/{id}/add-proposal")
    Call<Trade> addProposal(@Path("id") int tradeId, @Body AddProposalRequest addProposalRequest);
}
