package com.localloop.api.repositories;

import com.localloop.data.models.Advertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface AdvertisementRepository {
    void getAdvertisements(final DataCallBack<List<Advertisement>> callback);
}
