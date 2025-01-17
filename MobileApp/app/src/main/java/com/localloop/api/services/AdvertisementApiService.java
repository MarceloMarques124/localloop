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

    @GET("advertisements/{id}")
    Call<Advertisement> getAdvertisement(@Path("id") int id);

    @POST("advertisements")
    Call<Advertisement> createAdvertisement(@Body Advertisement advertisement);

    @PUT("advertisements/{id}")
    Call<Advertisement> updateAdvertisement(@Path("id") int id, @Body Advertisement advertisement);

    @DELETE("advertisements/{id}")
    Call<Void> deleteAdvertisement(@Path("id") int id);
}
