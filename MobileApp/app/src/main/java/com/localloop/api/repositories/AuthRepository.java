package com.localloop.api.repositories;

import com.localloop.api.requests.LoginRequest;
import com.localloop.api.requests.SignUpRequest;
import com.localloop.utils.DataCallBack;

public interface AuthRepository {
    void login(LoginRequest loginRequest, final DataCallBack<String> callBack);

    void signup(SignUpRequest signupRequest, final DataCallBack<String> callBack);
}
