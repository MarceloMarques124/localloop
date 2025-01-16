package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Advertisement extends BaseModel {
    private int id;

    @SerializedName("user_info_id")
    private int userId;

    private String title;
    private String description;

    @SerializedName("is_service")
    private Boolean isService;


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

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public boolean isService() {
        return isService;
    }

    public void setService(boolean service) {
        isService = service;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
}
