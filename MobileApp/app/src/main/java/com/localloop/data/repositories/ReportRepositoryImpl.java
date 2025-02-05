package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.ReportRepository;
import com.localloop.api.services.ReportApiService;
import com.localloop.data.models.Report;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ReportRepositoryImpl implements ReportRepository {
    private final ReportApiService apiService;

    public ReportRepositoryImpl(ReportApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void insertReport(String entityType, int reportId, DataCallBack<Report> callBack) {
        Call<Report> call = apiService.report(entityType, reportId);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<Report> call, @NonNull Response<Report> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to insert report"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<Report> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }

}