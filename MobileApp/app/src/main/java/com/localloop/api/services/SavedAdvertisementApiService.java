package com.localloop.api.services;

import com.localloop.data.models.SavedAdvertisement;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface SavedAdvertisementApiService {
    @GET("saved-advertisements")
    Call<List<SavedAdvertisement>> getSavedAdvertisements();

/*
    @POST("saved-advertisements/{id}")
    Call<SavedAdvertisement> saveAdvertisement(@Path("id") int advertisementId);

    */

    // Notice that we no longer pass an ID in the URL; instead, we send a JSON body.
    @POST("saved-advertisements")
    Call<SavedAdvertisement> saveAdvertisement(@Body int advertisementId);


    @DELETE("saved-advertisements/{id}")
    Call<Void> removeSavedAdvertisement(@Path("id") int advertisementId);
}

