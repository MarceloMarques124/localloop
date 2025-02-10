package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.CartRepository;
import com.localloop.api.services.CartApiService;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CartRepositoryImpl extends BaseRepositoryImpl implements CartRepository {

    private final CartApiService apiService;

    @Inject
    public CartRepositoryImpl(CartApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void toggleCartItem(int advertisementId, DataCallBack<Void> callBack) {
        var call = apiService.toggleCartItem(advertisementId);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<Void> call, @NonNull Response<Void> response) {
                callBack.onSuccess(response.body());
            }

            @Override
            public void onFailure(@NonNull Call<Void> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
