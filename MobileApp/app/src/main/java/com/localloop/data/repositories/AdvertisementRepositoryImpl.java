package com.localloop.data.repositories;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

public class AdvertisementRepositoryImpl extends BaseRepositoryImpl implements AdvertisementRepository {

    private final AdvertisementApiService apiService;

    @Inject
    public AdvertisementRepositoryImpl(AdvertisementApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getAdvertisements(DataCallBack<List<Advertisement>> callBack) {
        enqueueCall(apiService.getAdvertisements(), callBack, "");
    }

    @Override
    public void fetchAdvertisement(int id, DataCallBack<Advertisement> callBack) {
        enqueueCall(apiService.getAdvertisement(id), callBack, "");
    }

    @Override
    public void createAdvertisement(Advertisement advertisement, DataCallBack<Advertisement> callBack) {
        enqueueCall(apiService.createAdvertisement(advertisement), callBack, "");
    }
}