package com.localloop.api.services;

import com.localloop.data.models.Report;

import retrofit2.Call;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface ReportApiService {
    @POST("report/{id}")
    Call<Report> Report(@Path("id") int reportId);
}
