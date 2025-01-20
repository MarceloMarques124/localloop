package com.localloop.ui.auth;

import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.AuthRepository;
import com.localloop.api.requests.LoginRequest;
import com.localloop.api.requests.SignUpRequest;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class AuthViewModel extends BaseViewModel {

    private final MutableLiveData<String> loginResult = new MutableLiveData<>();
    private final AuthRepository authRepository;


    @Inject
    public AuthViewModel(AuthRepository authRepository) {
        super();

        this.authRepository = authRepository;
    }

    public void login(String username, String password) {
        LoginRequest loginRequest = new LoginRequest(username, password);

        authRepository.login(loginRequest, new DataCallBack<>() {
            @Override
            public void onSuccess(String data) {
                loginResult.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public MutableLiveData<String> getLoginResult() {
        return loginResult;
    }

    public void signup(String username, String password, String email) {
        SignUpRequest signUpRequest = new SignUpRequest(username, password, email);

        authRepository.signup(signUpRequest, new DataCallBack<>() {
            @Override
            public void onSuccess(String data) {
                loginResult.setValue(data);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}
