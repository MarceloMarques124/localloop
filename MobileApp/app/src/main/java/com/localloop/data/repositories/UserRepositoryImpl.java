package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.UserRepository;
import com.localloop.api.services.UserApiService;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UserRepositoryImpl implements UserRepository {
    private final UserApiService apiService;

    public UserRepositoryImpl(UserApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getUser(int id, DataCallBack<User> callBack) {
        var call = apiService.getUser(id);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<User> call, @NonNull Response<User> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError("Failed to fetch user");
                }
            }

            @Override
            public void onFailure(@NonNull Call<User> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }

    @Override
    public void getCurrentUser(DataCallBack<User> callBack) {
        var call = apiService.getCurrentUser();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<User> call, @NonNull Response<User> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to get Current User"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<User> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
