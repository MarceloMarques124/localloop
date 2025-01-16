package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdvertisementRepositoryImpl implements AdvertisementRepository {

    private final AdvertisementApiService apiService;

    public AdvertisementRepositoryImpl(AdvertisementApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getAdvertisements(final DataCallBack<List<Advertisement>> callback) {
        var call = apiService.getAdvertisements();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<List<Advertisement>> call, @NonNull Response<List<Advertisement>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callback.onSuccess(response.body());
                } else {
                    callback.onError("Failed to fetch advertisements");
                }
            }

            @Override
            public void onFailure(@NonNull Call<List<Advertisement>> call, @NonNull Throwable t) {
                callback.onError(t.getMessage());
            }
        });
    }
}
