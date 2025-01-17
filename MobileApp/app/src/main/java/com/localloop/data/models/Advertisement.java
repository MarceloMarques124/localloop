package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Advertisement extends BaseModel {
    public User user;
    private int id;
    @SerializedName("user_info_id")
    private int userId;
    private String title;
    private String description;
    @SerializedName("is_service")
    private Boolean isService;

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public Boolean getService() {
        return isService;
    }

    public void setService(Boolean service) {
        isService = service;
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

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
}
