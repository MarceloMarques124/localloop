package com.localloop.di;

import android.content.Context;

import com.localloop.utils.SecureStorage;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import dagger.hilt.InstallIn;
import dagger.hilt.android.qualifiers.ApplicationContext;
import dagger.hilt.components.SingletonComponent;

@Module
@InstallIn(SingletonComponent.class)
public class CacheModule {

    @Provides
    @Singleton
    public SecureStorage provideSecureStorage(@ApplicationContext Context context) {
        return new SecureStorage(context);
    }
}
