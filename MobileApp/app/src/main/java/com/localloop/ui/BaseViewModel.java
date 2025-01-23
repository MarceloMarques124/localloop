package com.localloop.ui;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class BaseViewModel extends ViewModel {
    protected final MutableLiveData<String> error = new MutableLiveData<>();

    public MutableLiveData<String> getError() {
        return error;
    }
}
