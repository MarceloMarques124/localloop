package com.localloop.api.repositories;

import com.localloop.data.models.User;
import com.localloop.utils.DataCallBack;

public interface UserRepository {
    void getUser(int id, final DataCallBack<User> callBack);
}
