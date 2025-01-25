package com.localloop.api.requests;

import java.util.List;

public class InitTradeRequest {
    private final int advertisementId;
    private final String message;
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
