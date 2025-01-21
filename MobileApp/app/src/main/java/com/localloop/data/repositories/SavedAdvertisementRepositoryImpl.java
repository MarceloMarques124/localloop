package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.api.services.SavedAdvertisementApiService;
import com.localloop.data.models.SavedAdvertisement;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SavedAdvertisementRepositoryImpl implements SavedAdvertisementRepository {
    private final SavedAdvertisementApiService apiService;

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

    }

    @Override
    public void removeSavedAdvertisement(int advertisementId, DataCallBack<Void> callBack) {

    }
}
