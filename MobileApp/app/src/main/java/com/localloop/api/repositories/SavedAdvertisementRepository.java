package com.localloop.api.repositories;

import com.localloop.data.models.SavedAdvertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface SavedAdvertisementRepository {

    void getSavedAdvertisements(DataCallBack<List<SavedAdvertisement>> callBack);

    void insertSavedAdvertisement(int advertisementId, DataCallBack<SavedAdvertisement> callBack);

    void removeSavedAdvertisement(int advertisementId, DataCallBack<Void> callBack);
}
