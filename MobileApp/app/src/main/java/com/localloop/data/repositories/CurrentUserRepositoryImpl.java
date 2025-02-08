package com.localloop.data.repositories;

import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.responses.UserProfile;
import com.localloop.api.services.CurrentUserApiService;
import com.localloop.data.models.Item;
import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

public class CurrentUserRepositoryImpl extends BaseRepositoryImpl implements CurrentUserRepository {
    private final CurrentUserApiService apiService;

    @Inject
    public CurrentUserRepositoryImpl(CurrentUserApiService apiService) {
        super();
        this.apiService = apiService;
    }

    @Override
    public void getUser(DataCallBack<User> callBack) {
        enqueueCall(apiService.getUser(), callBack, "Failed to get Current User");
    }

    @Override
    public void fetchItems(DataCallBack<List<Item>> callBack) {
        enqueueCall(apiService.fetchItems(), callBack, "Failed to get Current user items");
    }

    @Override
    public void getUserProfile(DataCallBack<UserProfile> callBack) {
        enqueueCall(apiService.getUserProfile(), callBack, "Failed to get the current user profile");
    }

    @Override
    public void getTradePartners(DataCallBack<List<User>> callBack) {
        enqueueCall(apiService.getTradePartners(), callBack, "Failed to get Current User Trade Partners");
    }
}
