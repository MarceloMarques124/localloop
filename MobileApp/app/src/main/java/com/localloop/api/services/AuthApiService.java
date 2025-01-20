package com.localloop.api.services;

import com.localloop.api.requests.LoginRequest;
import com.localloop.api.requests.SignUpRequest;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface AuthApiService {
    @POST("auth/login")
    Call<String> login(@Body LoginRequest postRequest);

    @POST("auth/signup")
    Call<String> signup(@Body SignUpRequest postRequest);
}
