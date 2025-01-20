package com.localloop.api.services;

import com.localloop.data.models.User;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

public interface SavedAdvertisementApiService {
    @GET("saved-advertisements")
    Call<List<User>> getUsers();

    @GET("saved-advertisements/{id}")
    Call<User> getUser(@Path("id") int id);

    @POST("saved-advertisements")
    Call<User> createUser(@Body User user);

    @PUT("saved-advertisements/{id}")
    Call<User> updateUser(@Path("id") int id, @Body User user);

    @DELETE("saved-advertisements/{id}")
    Call<Void> deleteUser(@Path("id") int id);
}
