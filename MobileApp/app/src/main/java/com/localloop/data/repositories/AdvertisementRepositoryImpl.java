package com.localloop.data.repositories;

import android.content.Context;

import com.localloop.R;
import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

public class AdvertisementRepositoryImpl extends BaseRepositoryImpl implements AdvertisementRepository {

    private final AdvertisementApiService apiService;
    private final Context context;

    public AdvertisementRepositoryImpl(AdvertisementApiService apiService, Context context) {
        this.apiService = apiService;
        this.context = context;
    }

    @Override
    public void getAdvertisements(DataCallBack<List<Advertisement>> callBack) {
        enqueueCall(apiService.getAdvertisements(), callBack, context.getString(R.string.FAILED_TO_FETCH, context.getString(R.string.THE_ADVERTISEMENT)));
    }

    @Override
    public void fetchAdvertisement(int id, DataCallBack<Advertisement> callBack) {
        enqueueCall(apiService.getAdvertisement(id), callBack, "Failed to fetch advertisement");
    }

    @Override
    public void createAdvertisement(Advertisement advertisement, DataCallBack<Advertisement> callBack) {
        enqueueCall(apiService.createAdvertisement(advertisement), callBack, "Failed to create advertisement");
    }
}