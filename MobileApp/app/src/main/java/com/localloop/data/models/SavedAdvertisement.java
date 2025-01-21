package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class SavedAdvertisement extends BaseModel{

    @SerializedName("user_info_id")
    private int userId;

    @SerializedName("advertisement_id")
    private int advertisementId;

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public int getAdvertisementId() {
        return advertisementId;
    }

    public void setAdvertisementId(int advertisementId) {
        this.advertisementId = advertisementId;
    }
}
