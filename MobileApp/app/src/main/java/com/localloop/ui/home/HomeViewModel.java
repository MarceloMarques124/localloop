package com.localloop.ui.home;

import androidx.annotation.NonNull;
import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.localloop.api.RetrofitClient;
import com.localloop.api.interfaces.AdvertisementApiService;
import com.localloop.models.Advertisement;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class HomeViewModel extends ViewModel {

    private final MutableLiveData<List<Advertisement>> advertisements;
    private final MutableLiveData<String> errorMessage;

    public HomeViewModel() {
        advertisements = new MutableLiveData<>();
        errorMessage = new MutableLiveData<>();
        loadAdvertisements();
    }
    
    private void loadAdvertisements() {
        AdvertisementApiService apiService = RetrofitClient.getApiService(AdvertisementApiService.class);
        Call<List<Advertisement>> call = apiService.getAdvertisements();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<List<Advertisement>> call, @NonNull Response<List<Advertisement>> response) {
                if (response.isSuccessful()) {
                    advertisements.setValue(response.body());
                } else {
                    errorMessage.setValue("Error: " + response.message());
                }
            }

            @Override
            public void onFailure(@NonNull Call<List<Advertisement>> call, @NonNull Throwable t) {
                errorMessage.setValue("Failure: " + t.getMessage());
            }
        });
    }

    public LiveData<List<Advertisement>> getAdvertisements() {
        return advertisements;
    }

    public LiveData<String> getErrorMessage() {
        return errorMessage;
    }
}
