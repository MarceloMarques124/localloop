package com.localloop.api.repositories;

import com.localloop.data.models.Advertisement;
import com.localloop.data.models.SavedAdvertisement;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface SavedAdvertisementRepository {

    // Method to get saved advertisements
    void getSavedAdvertisements(DataCallBack<List<SavedAdvertisement>> callBack);

    // Method to save an advertisement
    void insertSavedAdvertisement(int advertisementId, DataCallBack<SavedAdvertisement> callBack);

    // Method to remove a saved advertisement
    void removeSavedAdvertisement(int advertisementId, DataCallBack<Void> callBack);
}
