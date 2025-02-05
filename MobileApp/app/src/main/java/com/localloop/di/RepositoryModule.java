package com.localloop.di;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.AuthRepository;
import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.ReportRepository;
import com.localloop.api.repositories.SavedAdvertisementRepository;
import com.localloop.api.repositories.TradeRepository;
import com.localloop.api.repositories.UserRepository;
import com.localloop.data.repositories.AdvertisementRepositoryImpl;
import com.localloop.data.repositories.AuthRepositoryImpl;
import com.localloop.data.repositories.CurrentUserRepositoryImpl;
import com.localloop.data.repositories.ReportRepositoryImpl;
import com.localloop.data.repositories.SavedAdvertisementRepositoryImpl;
import com.localloop.data.repositories.TradeRepositoryImpl;
import com.localloop.data.repositories.UserRepositoryImpl;

import javax.inject.Singleton;

import dagger.Binds;
import dagger.Module;
import dagger.hilt.InstallIn;
import dagger.hilt.components.SingletonComponent;

@Module
@InstallIn(SingletonComponent.class)
public abstract class RepositoryModule {

    @Binds
    @Singleton
    abstract AdvertisementRepository bindAdvertisementRepository(AdvertisementRepositoryImpl repository);


    @Binds
    @Singleton
    abstract UserRepository bindUserRepository(UserRepositoryImpl repository);

    @Binds
    @Singleton
    abstract AuthRepository bindAuthRepository(AuthRepositoryImpl repository);

    @Binds
    @Singleton
    abstract SavedAdvertisementRepository bindSavedAdvertisementRepository(SavedAdvertisementRepositoryImpl repository);

    @Binds
    @Singleton
    abstract CurrentUserRepository bindCurrentUserRepository(CurrentUserRepositoryImpl repository);

    @Binds
    @Singleton
    abstract TradeRepository bindTradeRepository(TradeRepositoryImpl repository);

    @Binds
    @Singleton
    abstract ReportRepository bindReportRepository(ReportRepositoryImpl repository);


}
