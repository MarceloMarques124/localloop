package com.localloop.di;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.AuthRepository;
import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.repositories.UserRepository;
import com.localloop.api.services.AdvertisementApiService;
import com.localloop.api.services.AuthApiService;
import com.localloop.api.services.CurrentUserApiService;
import com.localloop.api.services.SavedAdvertisementApiService;
import com.localloop.api.services.TradeApiService;
import com.localloop.api.services.UserApiService;
import com.localloop.data.repositories.AdvertisementRepositoryImpl;
import com.localloop.data.repositories.AuthRepositoryImpl;
import com.localloop.data.repositories.CurrentUserRepositoryImpl;
import com.localloop.data.repositories.SavedAdvertisementRepositoryImpl;
import com.localloop.data.repositories.TradeRepositoryImpl;
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
    SavedAdvertisementRepository providesSavedAdvertisementRepository(SavedAdvertisementApiService apiService) {
        return new SavedAdvertisementRepositoryImpl(apiService);
    }

    @Provides
    @Singleton
    CurrentUserRepository providesCurrentUserRepository(CurrentUserApiService apiService) {
        return new CurrentUserRepositoryImpl(apiService);
    }

    @Provides
    @Singleton
    TradeRepository providesTradeRepository(TradeApiService apiService) {
        return new TradeRepositoryImpl(apiService);
    }

}
