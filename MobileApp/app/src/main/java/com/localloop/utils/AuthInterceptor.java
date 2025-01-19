package com.localloop.utils;

import androidx.annotation.NonNull;

import java.io.IOException;

import okhttp3.Interceptor;
import okhttp3.Response;

public class AuthInterceptor implements Interceptor {
    private final SecureStorage secureStorage;

    public AuthInterceptor(SecureStorage secureStorage) {
        this.secureStorage = secureStorage;
    }

    @NonNull
    @Override
    public Response intercept(@NonNull Chain chain) throws IOException {
        String authKey = secureStorage.getAuthKey();
        if (authKey != null) {
            return chain.proceed(chain.request().newBuilder()
                    .addHeader("Authorization", "Bearer " + authKey)
                    .build());
        } else {
            return chain.proceed(chain.request());
        }
    }
}
