package com.localloop.api.responses;

import com.google.gson.annotations.SerializedName;

public class TradeResponse {
    @SerializedName("trade_id")
    private int tradeId;

    @SerializedName("trade_state")
    private int tradeState;
    
    @SerializedName("advertisement_title")
    private String advertisementTitle;

    @SerializedName("last_proposal_message")
    private String lastProposalMessage;

    public int getTradeId() {
        return tradeId;
    }

    public void setTradeId(int tradeId) {
        this.tradeId = tradeId;
    }

    public int getTradeState() {
        return tradeState;
    }

    public void setTradeState(int tradeState) {
        this.tradeState = tradeState;
    }

    public String getAdvertisementTitle() {
        return advertisementTitle;
    }

    public void setAdvertisementTitle(String advertisementTitle) {
        this.advertisementTitle = advertisementTitle;
    }

    public String getLastProposalMessage() {
        return lastProposalMessage;
    }

    public void setLastProposalMessage(String lastProposalMessage) {
        this.lastProposalMessage = lastProposalMessage;
    }
}
