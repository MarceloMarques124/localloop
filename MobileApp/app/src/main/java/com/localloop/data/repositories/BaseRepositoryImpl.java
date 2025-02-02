package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.utils.DataCallBack;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class BaseRepositoryImpl {
    protected <T> void enqueueCall(Call<T> call, DataCallBack<T> callBack, String errorMessage) {
        call.enqueue(new Callback<T>() {
            @Override
            public void onResponse(@NonNull Call<T> call, @NonNull Response<T> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(errorMessage);
                }
            }

            @Override
            public void onFailure(@NonNull Call<T> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
