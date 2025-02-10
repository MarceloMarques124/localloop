package com.localloop.api.requests;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class AddProposalRequest {
    @SerializedName("item_ids")
    private final List<Integer> itemIds;
    private String message;

    public AddProposalRequest(List<Integer> itemIds, String message) {
        this.itemIds = itemIds;
        this.message = message;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public List<Integer> getItemIds() {
        return itemIds;
    }
}
