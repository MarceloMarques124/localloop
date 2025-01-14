package com.localloop.ui.home;

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

    // Method to fetch the advertisements
    private void loadAdvertisements() {
        AdvertisementApiService apiService = RetrofitClient.getApiService(AdvertisementApiService.class);
        Call<List<Advertisement>> call = apiService.getAdvertisements();

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(Call<List<Advertisement>> call, Response<List<Advertisement>> response) {
                if (response.isSuccessful()) {
                    advertisements.setValue(response.body()); // Set the data on success
                } else {
                    errorMessage.setValue("Error: " + response.message());
                }
            }

            @Override
            public void onFailure(Call<List<Advertisement>> call, Throwable t) {
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
