package com.localloop.api.repositories;

import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface AdvertisementRepository {
    void getAdvertisements(final DataCallBack<List<Advertisement>> callBack);

    void fetchAdvertisement(int id, final DataCallBack<Advertisement> callBack);

    void createAdvertisement(Advertisement advertisement,
                             DataCallBack<Advertisement> callback);

}
