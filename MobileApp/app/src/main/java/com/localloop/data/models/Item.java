package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class Item extends BaseModel {
    int id;
    String name;
    @SerializedName("user_info_id")
    int userId;
    @SerializedName("sub_category_id")
    int subCategoryID;

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

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public int getSubCategoryID() {
        return subCategoryID;
    }

    public void setSubCategoryID(int subCategoryID) {
        this.subCategoryID = subCategoryID;
    }
}
