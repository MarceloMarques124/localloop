package com.localloop.api.services;


import com.localloop.data.models.Advertisement;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

public interface AdvertisementApiService {
    @GET("advertisements")
    Call<List<Advertisement>> getAdvertisements();

    @GET("advertisement/{id}")
    Call<Advertisement> getAdvertisement(@Path("id") int id);

    @POST("advertisement")
    Call<Advertisement> createAdvertisement(@Body Advertisement advertisement);

    @PUT("advertisement/{id}")
    Call<Advertisement> updateAdvertisement(@Path("id") int id, @Body Advertisement advertisement);

    @DELETE("advertisement/{id}")
    Call<Void> deleteAdvertisement(@Path("id") int id);
}
