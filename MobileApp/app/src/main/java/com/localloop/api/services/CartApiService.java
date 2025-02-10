package com.localloop.api.services;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface CartApiService {
    @POST("cart/toggle-item")
    Call<Void> toggleCartItem(@Body int advertisementId);
}
