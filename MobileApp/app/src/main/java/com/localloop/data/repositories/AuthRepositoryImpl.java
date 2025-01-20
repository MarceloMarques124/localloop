package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.AuthRepository;
import com.localloop.api.requests.LoginRequest;
import com.localloop.api.requests.SignUpRequest;
import com.localloop.api.services.AuthApiService;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;
import com.localloop.utils.SecureStorage;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AuthRepositoryImpl implements AuthRepository {
    private final AuthApiService apiService;
    private final SecureStorage secureStorage;

    public AuthRepositoryImpl(AuthApiService apiService, SecureStorage secureStorage) {
        this.apiService = apiService;
        this.secureStorage = secureStorage;
    }

    @Override
    public void login(LoginRequest loginRequest, DataCallBack<String> callBack) {
        var call = apiService.login(loginRequest);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<String> call, @NonNull Response<String> response) {
                if (response.isSuccessful() && response.body() != null) {
                    String body = response.body();

                    secureStorage.storeAuthKey(body);
                    callBack.onSuccess(body);
                } else {
                    callBack.onError("Failed to Login");
                }
            }

            @Override
            public void onFailure(@NonNull Call<String> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }

    @Override
    public void signup(SignUpRequest signupRequest, DataCallBack<String> callBack) {
        var call = apiService.signup(signupRequest);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<String> call, @NonNull Response<String> response) {
                if (response.isSuccessful() && response.body() != null) {
                    String body = response.body();

                    secureStorage.storeAuthKey(body);
                    callBack.onSuccess(body);
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to signup user"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<String> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
