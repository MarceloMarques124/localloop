package com.localloop.api.services;

import com.localloop.data.models.TradeProposal;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.PATCH;
import retrofit2.http.Path;

public interface TradeProposalApiService {
    @PATCH("trade-proposals/{id}/update-status")
    Call<TradeProposal> updateTradeProposalStatus(
            @Path("id") int tradeProposalId,
            @Body int newState
    );

    @PATCH("trade-proposals/{id}/accept")
    Call<TradeProposal> acceptTradeProposal(@Path("id") int tradeProposalId);
}
