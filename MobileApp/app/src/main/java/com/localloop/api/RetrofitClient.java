package com.localloop.api;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.TypeAdapter;
import com.google.gson.stream.JsonReader;
import com.google.gson.stream.JsonWriter;
import com.localloop.BuildConfig;

import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClient {
    private static Retrofit retrofit;

    public static Retrofit getRetrofitInstance() {
        if (retrofit == null) {
            // Create a Gson instance with custom type adapters
            Gson gson = new GsonBuilder()
                    .registerTypeAdapter(Boolean.class, new BooleanTypeAdapter())  // Register the custom Boolean adapter
                    .registerTypeAdapter(LocalDateTime.class, new LocalDateTimeAdapter())  // Register the custom LocalDateTime adapter
                    .create();

            // Build Retrofit with the custom Gson converter
            retrofit = new Retrofit.Builder()
                    .baseUrl(BuildConfig.API_URL)
                    .addConverterFactory(GsonConverterFactory.create(gson))  // Use Gson with the custom type adapters
                    .build();
        }
        return retrofit;
    }

    public static <T> T getApiService(Class<T> serviceClass) {
        return getRetrofitInstance().create(serviceClass);
    }

    // Custom TypeAdapter for Boolean
    public static class BooleanTypeAdapter extends TypeAdapter<Boolean> {
        @Override
        public void write(JsonWriter out, Boolean value) throws IOException {
            out.value(value != null && value ? 1 : 0);  // Write 1 for true, 0 for false
        }

        @Override
        public Boolean read(JsonReader in) throws IOException {
            return in.nextInt() == 1;  // Convert 1 to true, 0 to false
        }
    }

    // Custom TypeAdapter for LocalDateTime
    public static class LocalDateTimeAdapter extends TypeAdapter<LocalDateTime> {

        // Define the custom format (matches the format in your JSON)
        private static final DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");

        @Override
        public void write(JsonWriter out, LocalDateTime value) throws IOException {
            // Write the LocalDateTime as a string in the custom format
            out.value(value != null ? value.format(formatter) : null);
        }

        @Override
        public LocalDateTime read(JsonReader in) throws IOException {
            // Parse the string back into LocalDateTime using the custom format
            String date = in.nextString();
            return date != null ? LocalDateTime.parse(date, formatter) : null;
        }
    }
}
