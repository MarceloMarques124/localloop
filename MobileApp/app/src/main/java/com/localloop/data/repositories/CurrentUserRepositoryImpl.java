package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.services.CurrentUserApiService;
import com.localloop.data.models.Item;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CurrentUserRepositoryImpl implements CurrentUserRepository {
    private final CurrentUserApiService apiService;

    public CurrentUserRepositoryImpl(CurrentUserApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getUser(DataCallBack<User> callBack) {
        var call = apiService.getUser();

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

    @Override
    public void fetchItems(DataCallBack<List<Item>> callBack) {
        var call = apiService.fetchItems();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<List<Item>> call, @NonNull Response<List<Item>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to get Current User"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<List<Item>> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
