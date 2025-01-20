package com.localloop.utils;

import com.google.gson.TypeAdapter;
import com.google.gson.stream.JsonReader;
import com.google.gson.stream.JsonWriter;

import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class Adapters {
    public static class BooleanTypeAdapter extends TypeAdapter<Boolean> {
        @Override
        public void write(JsonWriter out, Boolean value) throws IOException {
            out.value(value != null && value ? 1 : 0);
        }

        @Override
        public Boolean read(JsonReader in) throws IOException {
            return in.nextInt() == 1;
        }
    }

    public static class LocalDateTimeAdapter extends TypeAdapter<LocalDateTime> {
        private static final DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");

        @Override
        public void write(JsonWriter out, LocalDateTime value) throws IOException {
            out.value(value != null ? value.format(formatter) : null);
        }

        @Override
        public LocalDateTime read(JsonReader in) throws IOException {
            String date = in.nextString();
            return date != null ? LocalDateTime.parse(date, formatter) : null;
        }
    }
}
