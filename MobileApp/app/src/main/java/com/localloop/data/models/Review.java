package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Review {
    private int id;
    @SerializedName("user_info_id")
    private int userId;

    @SerializedName("trade_id")
    private int tradeId;

    @SerializedName("stars")
    private int stars;

    @SerializedName("message")
    private String message;

    @SerializedName("title")
    private String title;

    public Review(int userId, int tradeId, int stars, String message, String title) {
        this.userId = userId;
        this.tradeId = tradeId;
        this.stars = stars;
        this.message = message;
        this.title = title;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
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

    public int getStars() {
        return stars;
    }

    public void setStars(int stars) {
        this.stars = stars;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
