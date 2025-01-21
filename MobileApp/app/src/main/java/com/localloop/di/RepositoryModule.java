package com.localloop.di;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.AuthRepository;
import com.localloop.api.repositories.ItemRepository;
import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.api.repositories.UserRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.api.services.AuthApiService;
import com.localloop.api.services.ItemApiService;
import com.localloop.api.services.SavedAdvertisementApiService;
import com.localloop.api.services.UserApiService;
import com.localloop.data.repositories.AdvertisementRepositoryImpl;
import com.localloop.data.repositories.AuthRepositoryImpl;
import com.localloop.data.repositories.ItemRepositoryImpl;
import com.localloop.data.repositories.SavedAdvertisementRepositoryImpl;
import com.localloop.data.repositories.UserRepositoryImpl;
import com.localloop.utils.SecureStorage;

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

    @Provides
    @Singleton
    UserRepository providesUserRepository(UserApiService apiService) {
        return new UserRepositoryImpl(apiService);
    }

    @Provides
    @Singleton
    AuthRepository providesAuthRepository(AuthApiService apiService, SecureStorage secureStorage) {
        return new AuthRepositoryImpl(apiService, secureStorage);
    }

    @Provides
    @Singleton
    ItemRepository providesItemRepository(ItemApiService apiService, SecureStorage secureStorage) {
        return new ItemRepositoryImpl(apiService);
    }

    @Provides
    @Singleton
    SavedAdvertisementRepository providesSavedAdvertisementRepository(SavedAdvertisementApiService apiService) {
        return new SavedAdvertisementRepositoryImpl(apiService);
    }

}
