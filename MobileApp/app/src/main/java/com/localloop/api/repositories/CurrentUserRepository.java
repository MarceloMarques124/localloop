package com.localloop.api.repositories;

import com.localloop.data.models.Item;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface CurrentUserRepository {
    void getUser(DataCallBack<User> callBack);

    void fetchItems(DataCallBack<List<Item>> callBack);

    void getTradePartners(DataCallBack<List<User>> callBack);
}
