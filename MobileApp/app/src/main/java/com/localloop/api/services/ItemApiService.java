package com.localloop.api.services;

import com.localloop.data.models.Item;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

public interface ItemApiService {

    @GET("items")
    Call<List<Item>> getItems();

    @GET("items/{id}")
    Call<Item> getItem(@Path("id") int id);

    @POST("items")
    Call<Item> createItem(@Body Item user);

    @PUT("items/{id}")
    Call<Item> updateItem(@Path("id") int id, @Body Item user);

    @DELETE("items/{id}")
    Call<Void> deleteItem(@Path("id") int id);

    @GET("items/current-user-items")
    Call<List<Item>> getCurrentUserItems();
}
