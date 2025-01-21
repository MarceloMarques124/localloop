package com.localloop.di;

import android.app.Application;
import android.content.Context;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.localloop.BuildConfig;
import com.localloop.utils.Adapters;
import com.localloop.utils.AuthInterceptor;
import com.localloop.utils.SecureStorage;

import java.time.LocalDateTime;
import java.util.concurrent.TimeUnit;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import dagger.hilt.InstallIn;
import dagger.hilt.components.SingletonComponent;
import okhttp3.Interceptor;
import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

@Module
@InstallIn(SingletonComponent.class)
public class AppModule {

    @Provides
    @Singleton
    public OkHttpClient provideOkHttpClient(SecureStorage secureStorage) {
        Interceptor connectionCloseInterceptor = chain -> chain.proceed(chain.request());

        return new OkHttpClient.Builder()
                .connectTimeout(60, TimeUnit.SECONDS)
                .readTimeout(60, TimeUnit.SECONDS)
                .writeTimeout(60, TimeUnit.SECONDS)
                .addInterceptor(new HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY))
                .addInterceptor(new AuthInterceptor(secureStorage))
                .addInterceptor(connectionCloseInterceptor)
                .build();
    }

    @Provides
    @Singleton
    public Gson provideGson() {
        return new GsonBuilder()
                .registerTypeAdapter(Boolean.class, new Adapters.BooleanTypeAdapter())
                .registerTypeAdapter(LocalDateTime.class, new Adapters.LocalDateTimeAdapter())
                .create();
    }

    @Provides
    @Singleton
    public Retrofit provideRetrofit(OkHttpClient okHttpClient, Gson gson) {
        return new Retrofit.Builder()
                .baseUrl(BuildConfig.API_URL)
                .client(okHttpClient)
                .addConverterFactory(GsonConverterFactory.create(gson))
                .build();
    }

    @Provides
    @Singleton
    public Context provideContext(Application application) {
        return application.getApplicationContext();
    }
}
