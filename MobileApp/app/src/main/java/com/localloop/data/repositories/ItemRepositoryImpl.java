package com.localloop.data.repositories;

import androidx.annotation.NonNull;

import com.localloop.api.repositories.ItemRepository;
import com.localloop.api.services.ItemApiService;
import com.localloop.data.models.Item;
import com.localloop.utils.DataCallBack;
import com.localloop.utils.ErrorRequest;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ItemRepositoryImpl implements ItemRepository {


    private final ItemApiService apiService;

    public ItemRepositoryImpl(ItemApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getCurrentUserItems(DataCallBack<List<Item>> callBack) {
        var call = apiService.getCurrentUserItems();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<List<Item>> call, @NonNull Response<List<Item>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError(ErrorRequest.getErrorResponse(response.errorBody(), "Failed to get Current User Items"));
                }
            }

            @Override
            public void onFailure(@NonNull Call<List<Item>> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }
}
