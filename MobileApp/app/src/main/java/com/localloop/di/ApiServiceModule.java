package com.localloop.di;

import com.localloop.api.services.AdvertisementApiService;

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
    public AdvertisementApiService provideApiService(Retrofit retrofit) {
        return retrofit.create(AdvertisementApiService.class);
    }
}
