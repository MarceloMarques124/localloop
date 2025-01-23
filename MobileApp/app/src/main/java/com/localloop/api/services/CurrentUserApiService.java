package com.localloop.api.services;

import com.localloop.data.models.Item;
import com.localloop.data.models.User;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface CurrentUserApiService {

    @GET("current-user")
    Call<User> getUser();

    @GET("current-user/items")
    Call<List<Item>> getItems();
}
