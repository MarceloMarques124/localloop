package com.localloop.api.repositories;

import com.localloop.utils.DataCallBack;

public interface CartRepository {
    void toggleCartItem(int advertisementId, DataCallBack<Void> callBack);
}
