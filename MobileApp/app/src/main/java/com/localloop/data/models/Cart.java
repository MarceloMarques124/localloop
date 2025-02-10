package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class Cart extends BaseModel {
    private int id;
    private int state;
    @SerializedName("items")
    private List<CartItem> items;

    public List<CartItem> getItems() {
        return items;
    }

    public void setItems(List<CartItem> items) {
        this.items = items;
    }

    public int getState() {
        return state;
    }

    public void setState(int state) {
        this.state = state;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
}
