package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Review {
    private int id;
    @SerializedName("user_id")
    private int userId;
    @SerializedName("trade_id")
    private int tradeId;
    private int rating;
    private String comment;

    public Review(int userId, int tradeId, int rating, String comment) {
        this.userId = userId;
        this.tradeId = tradeId;
        this.rating = rating;
        this.comment = comment;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
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

    public int getRating() {
        return rating;
    }

    public void setRating(int rating) {
        this.rating = rating;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }
}
