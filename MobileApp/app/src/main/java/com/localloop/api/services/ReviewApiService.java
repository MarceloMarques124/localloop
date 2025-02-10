package com.localloop.api.services;

import com.localloop.data.models.Review;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

public interface ReviewApiService {

    @GET("reviews")
    Call<List<Review>> getReviews();

    @GET("reviews/{id}")
    Call<Review> getReview(@Path("id") int id);

    @POST("reviews")
    Call<Review> createReview(@Body Review review);

    @PUT("reviews/{id}")
    Call<Review> updateReview(@Path("id") int id, @Body Review review);

    @DELETE("reviews/{id}")
    Call<Void> deleteReview(@Path("id") int id);
}
