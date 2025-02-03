package com.localloop.data.repositories;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.data.models.Advertisement;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdvertisementRepositoryImpl extends BaseRepositoryImpl implements AdvertisementRepository {

    private final AdvertisementApiService apiService;
    private final CurrentUserRepository currentUserRepository;

    @Inject
    public AdvertisementRepositoryImpl(AdvertisementApiService apiService,
            CurrentUserRepository currentUserRepository) {
        this.apiService = apiService;
        this.currentUserRepository = currentUserRepository;
    }

    @Override
    public void getAdvertisements(DataCallBack<List<Advertisement>> callBack) {
        enqueueCall(apiService.getAdvertisements(), callBack, "");
    }

    @Override
    public void fetchAdvertisement(int id, DataCallBack<Advertisement> callBack) {
        var call = apiService.getAdvertisement(id);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<Advertisement> call, @NonNull Response<Advertisement> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callBack.onSuccess(response.body());
                } else {
                    callBack.onError("Failed to fetch advertisement");
                }
            }

            @Override
            public void onFailure(@NonNull Call<Advertisement> call, @NonNull Throwable t) {
                callBack.onError(t.getMessage());
            }
        });
    }

    @Override
    public void createAdvertisement(String title, String description, boolean isService, String imagePath,
            final DataCallBack<Advertisement> callback) {
        currentUserRepository.getUser(new DataCallBack<>() {
            @Override
            public void onSuccess(User user) {
                createdAd(user, title, description, isService, callback);
            }

            @Override
            public void onError(String error) {
                callback.onError(error);
            }
        });
    }

    private void createdAd(User user, String title, String description, boolean isService,
            DataCallBack<Advertisement> callback) {
        int userId = user.getId();
        Advertisement advertisement = new Advertisement(userId, title, description, isService);
        var call = apiService.createAdvertisement(advertisement);

        call.enqueue(new Callback<>() {
            @Override
            public void onResponse(@NonNull Call<Advertisement> call, @NonNull Response<Advertisement> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callback.onSuccess(response.body());
                } else {
                    callback.onError("Failed to create advertisement");
                }
            }

            @Override
            public void onFailure(@NonNull Call<Advertisement> call, @NonNull Throwable t) {
                callback.onError(t.getMessage());
            }
        });
    }
}
