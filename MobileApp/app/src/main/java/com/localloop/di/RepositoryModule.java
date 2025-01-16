package com.localloop.di;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.data.repositories.AdvertisementRepositoryImpl;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import dagger.hilt.InstallIn;
import dagger.hilt.components.SingletonComponent;

@Module
@InstallIn(SingletonComponent.class)
public class RepositoryModule {

    @Provides
    @Singleton
    AdvertisementRepository providesAdvertisementRepository(AdvertisementApiService apiService) {
        return new AdvertisementRepositoryImpl(apiService);
    }
}
