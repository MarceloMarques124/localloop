package com.localloop.api.requests;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class InitTradeRequest {
    @SerializedName("advertisement_id")
    private final int advertisementId;
    private final String message;
    @SerializedName("item_ids")
    private final List<Integer> itemIds;

    public InitTradeRequest(int advertisementId, String message, List<Integer> itemIds) {
        this.advertisementId = advertisementId;
        this.message = message;
        this.itemIds = itemIds;
    }

    public int getAdvertisementId() {
        return advertisementId;
    }

    public String getMessage() {
        return message;
    }

    public List<Integer> getItemIds() {
        return itemIds;
    }
}
