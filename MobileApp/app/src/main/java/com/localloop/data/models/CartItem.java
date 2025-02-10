package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class CartItem extends BaseModel {
    @SerializedName("cart_id")
    private int cartId;
    @SerializedName("advertisement_id")
    private int advertisementId;
    private Advertisement advertisement;

    public Advertisement getAdvertisement() {
        return advertisement;
    }

    public void setAdvertisement(Advertisement advertisement) {
        this.advertisement = advertisement;
    }

    public int getAdvertisementId() {
        return advertisementId;
    }

    public void setAdvertisementId(int advertisementId) {
        this.advertisementId = advertisementId;
    }

    public int getCartId() {
        return cartId;
    }

    public void setCartId(int cartId) {
        this.cartId = cartId;
    }
}
