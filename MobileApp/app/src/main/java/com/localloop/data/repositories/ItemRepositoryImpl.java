package com.localloop.data.repositories;

import com.localloop.api.repositories.ItemRepository;
import com.localloop.api.services.ItemApiService;
import com.localloop.data.models.Item;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

public class ItemRepositoryImpl extends BaseRepositoryImpl implements ItemRepository {
    private final ItemApiService apiService;

    @Inject
    public ItemRepositoryImpl(ItemApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getItems(int userId, DataCallBack<List<Item>> callBack) {
        enqueueCall(apiService.getItems(userId), callBack, "Failed to get User Items");
    }
}
