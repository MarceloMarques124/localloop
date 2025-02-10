package com.localloop.api.repositories;

import com.localloop.data.models.Item;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface ItemRepository {
    void getItems(int userId, DataCallBack<List<Item>> items);
}
