package com.localloop.api.repositories;

import com.localloop.api.responses.TradeResponse;
import com.localloop.api.responses.UserProfile;
import com.localloop.data.models.Item;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface CurrentUserRepository {
    void getUser(DataCallBack<User> callBack);

    void fetchItems(DataCallBack<List<Item>> callBack);

    void getUserProfile(DataCallBack<UserProfile> callBack);

    void getSentTrades(DataCallBack<List<TradeResponse>> callBack);

    void getReceivedTrades(DataCallBack<List<TradeResponse>> callBack);
}
