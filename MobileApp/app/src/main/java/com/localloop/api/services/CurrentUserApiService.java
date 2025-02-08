package com.localloop.api.services;

import com.localloop.api.responses.UserProfile;
import com.localloop.data.models.Item;
import com.localloop.data.models.User;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface CurrentUserApiService {

    @GET("current-user")
    Call<User> getUser();

    @GET("current-user/items")
    Call<List<Item>> fetchItems();

    @GET("current-user/profile")
    Call<UserProfile> getUserProfile();
}
