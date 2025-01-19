package com.localloop.utils;

import android.content.Context;

import androidx.security.crypto.EncryptedSharedPreferences;
import androidx.security.crypto.MasterKeys;

import java.io.IOException;
import java.security.GeneralSecurityException;

public class SecureStorage {
    private static final String PREFERENCES_FILE = "secure_prefs";
    private static final String AUTH_KEY = "auth_key";

    private EncryptedSharedPreferences encryptedSharedPreferences;

    public SecureStorage(Context context) {
        try {
            // Correct way to get or create the master key
            String masterKeyAlias = MasterKeys.getOrCreate(MasterKeys.AES256_GCM_SPEC);

            encryptedSharedPreferences = (EncryptedSharedPreferences) EncryptedSharedPreferences.create(
                    PREFERENCES_FILE,
                    masterKeyAlias,
                    context,
                    EncryptedSharedPreferences.PrefKeyEncryptionScheme.AES256_SIV,
                    EncryptedSharedPreferences.PrefValueEncryptionScheme.AES256_GCM
            );
        } catch (GeneralSecurityException | IOException e) {
            e.printStackTrace();
        }
    }

    // Storing the Auth Key securely
    public void storeAuthKey(String authKey) {
        encryptedSharedPreferences.edit().putString(AUTH_KEY, authKey).apply();
    }

    // Retrieving the Auth Key securely
    public String getAuthKey() {
        return encryptedSharedPreferences.getString(AUTH_KEY, null);
    }

    // Removing the Auth Key securely
    public void removeAuthKey() {
        encryptedSharedPreferences.edit().remove(AUTH_KEY).apply();
    }
}
