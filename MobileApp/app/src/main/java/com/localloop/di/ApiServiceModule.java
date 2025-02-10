package com.localloop.di;

import com.localloop.api.services.AdvertisementApiService;
import com.localloop.api.services.AuthApiService;
import com.localloop.api.services.CurrentUserApiService;
import com.localloop.api.services.ItemApiService;
import com.localloop.api.services.SavedAdvertisementApiService;
import com.localloop.api.services.TradeApiService;
import com.localloop.api.services.TradeProposalApiService;
import com.localloop.api.services.UserApiService;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import dagger.hilt.InstallIn;
import dagger.hilt.components.SingletonComponent;
import retrofit2.Retrofit;

@Module
@InstallIn(SingletonComponent.class)
public class ApiServiceModule {
    @Provides
    @Singleton
    public AdvertisementApiService provideAdvertisementApiService(Retrofit retrofit) {
        return retrofit.create(AdvertisementApiService.class);
    }

    @Provides
    @Singleton
    public UserApiService provideUserApiService(Retrofit retrofit) {
        return retrofit.create(UserApiService.class);
    }

    @Provides
    @Singleton
    public AuthApiService provideAuthApiService(Retrofit retrofit) {
        return retrofit.create(AuthApiService.class);
    }

    @Provides
    @Singleton
    public ItemApiService provideItemApiService(Retrofit retrofit) {
        return retrofit.create(ItemApiService.class);
    }

    @Provides
    @Singleton
    public SavedAdvertisementApiService provideSavedAdvertisementApiService(Retrofit retrofit) {
        return retrofit.create(SavedAdvertisementApiService.class);
    }

    @Provides
    @Singleton
    public CurrentUserApiService provideCurrentUserApiService(Retrofit retrofit) {
        return retrofit.create(CurrentUserApiService.class);
    }

    @Provides
    @Singleton
    public TradeApiService provideTradeApiService(Retrofit retrofit) {
        return retrofit.create(TradeApiService.class);
    }

    @Provides
    @Singleton
    public TradeProposalApiService provideTradeProposalApiService(Retrofit retrofit) {
        return retrofit.create(TradeProposalApiService.class);
    }
}
