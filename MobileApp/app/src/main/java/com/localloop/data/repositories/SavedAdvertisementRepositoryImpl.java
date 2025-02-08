package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.api.services.SavedAdvertisementApiService;
import com.localloop.data.models.SavedAdvertisement;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import java.util.List;

import javax.inject.Inject;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SavedAdvertisementRepositoryImpl implements SavedAdvertisementRepository {
    private final SavedAdvertisementApiService apiService;

    @Inject
    public SavedAdvertisementRepositoryImpl(SavedAdvertisementApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getSavedAdvertisements(DataCallBack<List<SavedAdvertisement>> callBack) {

        Call<List<SavedAdvertisement>> call = apiService.getSavedAdvertisements();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<List<SavedAdvertisement>> call, @NonNull Response<List<SavedAdvertisement>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to get Saved Advertisement"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<List<SavedAdvertisement>> call, @NonNull Throwable t) {

                callBack.onError(t.getMessage());

            }
        });

    }

    @Override
    public void insertSavedAdvertisement(int advertisementId, DataCallBack<SavedAdvertisement> callBack) {
        Call<SavedAdvertisement> call = apiService.saveAdvertisement(advertisementId);
        call.enqueue(new Callback<SavedAdvertisement>() {
            @Override
            public void onResponse(@NonNull Call<SavedAdvertisement> call, @NonNull Response<SavedAdvertisement> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to save advertisement"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<SavedAdvertisement> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });

    }

    @Override
    public void removeSavedAdvertisement(int advertisementId, DataCallBack<Void> callBack) {
        Call<Void> call = apiService.removeSavedAdvertisement(advertisementId);
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(@NonNull Call<Void> call, @NonNull Response<Void> response) {
                if (response.isSuccessful()) {
                    callBack.onSuccess(null);
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to remove saved advertisement"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<Void> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
