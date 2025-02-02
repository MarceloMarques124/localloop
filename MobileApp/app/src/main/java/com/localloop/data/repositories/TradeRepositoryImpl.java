package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.requests.InitTradeRequest;
import com.localloop.api.services.TradeApiService;
import com.localloop.data.models.Trade;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class TradeRepositoryImpl implements TradeRepository {
    private final TradeApiService tradeApiService;

    @Inject
    public TradeRepositoryImpl(TradeApiService tradeApiService) {
        this.tradeApiService = tradeApiService;
    }

    @Override
    public void initTrade(InitTradeRequest trade, DataCallBack<Trade> callBack) {
        var call = tradeApiService.initTrade(trade);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<Trade> call, @NonNull Response<Trade> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError("Failed to save Trade");
                }
            }

            @Override
            public void onFailure(@NonNull Call<Trade> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
