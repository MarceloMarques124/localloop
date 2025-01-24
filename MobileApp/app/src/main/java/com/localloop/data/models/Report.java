package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Report {
    @SerializedName("advertisement_id")
    private int advertisementId;

    @SerializedName("user_info_id")
    private int userId;

    @SerializedName("trade_id")
    private int tradeId;

    public int getAdvertisementId() {
        return advertisementId;
    }

    public void setAdvertisementId(int advertisementId) {
        this.advertisementId = advertisementId;
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public int getTradeId() {
        return tradeId;
    }

    public void setTradeId(int tradeId) {
        this.tradeId = tradeId;
    }
}
