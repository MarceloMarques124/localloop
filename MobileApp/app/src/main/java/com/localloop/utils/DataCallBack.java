package com.localloop.utils;

public interface DataCallBack<T> {
    void onSuccess(T data);

    void onError(String errorMessage);
}
