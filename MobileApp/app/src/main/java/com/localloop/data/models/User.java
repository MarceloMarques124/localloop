package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class User extends BaseModel {
    private int id;
    private String name;
    private String address;

    @SerializedName("postal_code")
    private String postalCode;

    @SerializedName("flagged_for_ban")
    private int flaggedForBan;
    private String username;
    private String email;
    private int status;

    @SerializedName("average_stars")
    private Float averageStars;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getPostalCode() {
        return postalCode;
    }

    public void setPostalCode(String postalCode) {
        this.postalCode = postalCode;
    }

    public int getFlaggedForBan() {
        return flaggedForBan;
    }

    public void setFlaggedForBan(int flaggedForBan) {
        this.flaggedForBan = flaggedForBan;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public Float getAverageStars() {
        return averageStars;
    }

    public void setAverageStars(Float averageStars) {
        this.averageStars = averageStars;
    }
}
