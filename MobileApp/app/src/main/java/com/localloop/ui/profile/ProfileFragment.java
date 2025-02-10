package com.localloop.ui.profile;

import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.textview.MaterialTextView;
import com.localloop.R;
import com.localloop.api.responses.UserProfile;
import com.localloop.data.models.CartItem;
import com.localloop.data.models.User;
import com.localloop.databinding.FragmentProfileBinding;
import com.localloop.ui.auth.AuthActivity;

import java.util.List;

import dagger.hilt.android.AndroidEntryPoint;

@AndroidEntryPoint
public class ProfileFragment extends Fragment {

    private ProfileViewModel profileViewModel;
    private FragmentProfileBinding binding;
    private CartItemAdapter cartItemAdapter;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentProfileBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        profileViewModel = new ViewModelProvider(this).get(ProfileViewModel.class);
        setupObservers();
        profileViewModel.getCurrentUserProfile();

        binding.signOutButton.setOnClickListener(v -> {
            profileViewModel.signOut();
            Intent intent = new Intent(requireActivity(), AuthActivity.class);
            startActivity(intent);
            requireActivity().finish();
        });
    }

    private void setupObservers() {
        profileViewModel.getUserProfileLiveData().observe(getViewLifecycleOwner(), userProfile -> {
            if (userProfile != null) {
                updateUI(userProfile);
            }
        });

        profileViewModel.getError().observe(getViewLifecycleOwner(), error -> {
            if (error != null) {
                showErrorPopup(getContext(), error);
            }
        });
    }


    private void showErrorPopup(Context context, String errorMessage) {
        new AlertDialog.Builder(context)
                .setTitle(getString(R.string.ERROR))
                .setMessage(errorMessage)
                .setPositiveButton("OK", (dialog, which) -> dialog.dismiss())
                .create()
                .show();
    }

    private void updateUI(UserProfile userProfile) {
        User user = userProfile.getUser();
        if (user != null) {
            binding.userName.setText(userProfile.getUser().getName());
            binding.userEmail.setText(userProfile.getUser().getEmail());
            binding.userAddress.setText(userProfile.getUser().getAddress());
            binding.userPostalCode.setText(userProfile.getUser().getPostalCode());
        }

        handleCartSection(userProfile);
    }

    private void handleCartSection(UserProfile userProfile) {
        if (userProfile.getCart() != null && userProfile.getCart().getItems() != null) {
            setupCartRecyclerView(userProfile.getCart().getItems());
        } else {
            binding.cartSection.setVisibility(View.GONE);
        }
    }

    private void setupCartRecyclerView(List<CartItem> cartItems) {
        if (cartItems == null || cartItems.isEmpty()) {
            binding.cartSection.setVisibility(View.GONE);
            return;
        }

        binding.cartSection.setVisibility(View.VISIBLE);
        binding.cartTitle.setText(getCartTitle(cartItems.size()));

        if (cartItemAdapter == null) {
            cartItemAdapter = new CartItemAdapter(cartItems);
            binding.cartRecyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
            binding.cartRecyclerView.setAdapter(cartItemAdapter);
            binding.cartRecyclerView.setNestedScrollingEnabled(false);
        } else {
            cartItemAdapter.updateItems(cartItems);
        }
    }

    private String getCartTitle(int itemCount) {
        return "Cart (" + itemCount + " " + (itemCount == 1 ? "item" : "items") + ")";
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    private static class CartItemAdapter extends RecyclerView.Adapter<CartItemAdapter.ViewHolder> {
        private List<CartItem> cartItems;

        public CartItemAdapter(List<CartItem> cartItems) {
            this.cartItems = cartItems;
        }

        public void updateItems(List<CartItem> newItems) {
            this.cartItems = newItems;
            notifyDataSetChanged();
        }

        @NonNull
        @Override
        public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
            View view = LayoutInflater.from(parent.getContext())
                    .inflate(R.layout.generic_item, parent, false);
            return new ViewHolder(view);
        }

        @Override
        public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
            CartItem cartItem = cartItems.get(position);
            if (cartItem.getAdvertisement() != null) {
                holder.title.setText(cartItem.getAdvertisement().getTitle());
                String itemType = Boolean.TRUE.equals(cartItem.getAdvertisement().getService())
                        ? "Service"
                        : "Item";
                holder.type.setText(itemType);
            }
        }

        @Override
        public int getItemCount() {
            return cartItems.size();
        }

        static class ViewHolder extends RecyclerView.ViewHolder {
            final MaterialTextView title;
            final MaterialTextView type;

            ViewHolder(View itemView) {
                super(itemView);
                title = itemView.findViewById(R.id.itemTitle);
                type = itemView.findViewById(R.id.itemType);
            }
        }
    }
}