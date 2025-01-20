package com.localloop.ui.auth;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.lifecycle.ViewModelProvider;

import com.localloop.MainActivity;
import com.localloop.R;
import com.localloop.databinding.ActivityAuthBinding;
import com.localloop.utils.SecureStorage;

import javax.inject.Inject;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class AuthActivity extends AppCompatActivity {

    @Inject
    SecureStorage secureStorage;
    private boolean isLogin = true;
    private ActivityAuthBinding binding;
    private AuthViewModel viewModel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);

        binding = ActivityAuthBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        viewModel = new ViewModelProvider(this).get(AuthViewModel.class);

        if (secureStorage.getAuthKey() != null) {
            navigateToHome();
            return;
        }

        getSupportActionBar().hide();

        updateAuthForm();

        binding.loginButton.setOnClickListener(v -> {
            String username = binding.username.getText().toString();
            String password = binding.password.getText().toString();
            String email = binding.email.getText().toString();

            if (setValidationErrors(username, password, email)) {
                if (isLogin) {
                    viewModel.login(username, password);
                } else {
                    viewModel.signup(username, password, email);
                }
            }
        });

        binding.switchAuth.setOnClickListener(v -> {
            isLogin = !isLogin;
            updateAuthForm();
        });

        viewModel.getLoginResult().observe(this, result -> navigateToHome());
        viewModel.getError().observe(this, error -> Toast.makeText(AuthActivity.this, "Error: " + error, Toast.LENGTH_SHORT).show());
    }

    private boolean setValidationErrors(String username, String password, String email) {
        if (username.isEmpty()) {
            binding.username.setError(getString(R.string.THE_FIELD_CANT_BE_EMPTY, getString(R.string.USERNAME)));
            return false;
        }

        if (password.isEmpty()) {
            binding.password.setError(getString(R.string.THE_FIELD_CANT_BE_EMPTY, getString(R.string.PASSWORD)));
            return false;
        }

        if (!isLogin) {
            if (email.isEmpty()) {
                binding.email.setError(getString(R.string.THE_FIELD_CANT_BE_EMPTY, getString(R.string.EMAIL)));
                return false;
            }

            if (!Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
                binding.email.setError(getString(R.string.INVALID_EMAIL));
                return false;
            }
        }

        return true;
    }

    private void updateAuthForm() {
        if (isLogin) {
            binding.authHeader.setText(R.string.LOGIN);
            binding.loginButton.setText(R.string.LOGIN);
            binding.switchAuth.setText(R.string.DONT_HAVE_AN_ACCOUNT_SIGN_UP);

            binding.email.setVisibility(View.GONE);
        } else {
            binding.authHeader.setText(R.string.SIGN_UP);
            binding.loginButton.setText(R.string.SIGN_UP);
            binding.switchAuth.setText(R.string.ALREADY_HAVE_AN_ACCOUNT_LOG_IN);

            binding.email.setVisibility(View.VISIBLE);
        }
    }

    private void navigateToHome() {
        Intent intent = new Intent(AuthActivity.this, MainActivity.class);
        startActivity(intent);
        finish();
    }
}
