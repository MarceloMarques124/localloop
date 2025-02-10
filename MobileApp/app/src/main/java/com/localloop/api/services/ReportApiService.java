package com.localloop.api.services;

/*public interface ReportApiService {
    @POST("report/{id}")
    Call<Report> Report(@Path("id") int reportId);
}
*/

/*
public interface ReportApiService {
    @POST("report/create")
    Call<Report> Report(
            @Query("entityType") String entityType,
            @Query("reportId") int reportId
    );

}

*/


import com.localloop.data.models.Report;

import retrofit2.Call;
import retrofit2.http.POST;
import retrofit2.http.Query;


public interface ReportApiService {
    @POST("report/create")
    Call<Report> report(
            @Query("entityType") String entityType,
            @Query("reportId") int reportId
    );
}
