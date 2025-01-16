package com.localloop.ui.home;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.Advertisement;

import java.util.List;

public class CardAdapter extends RecyclerView.Adapter<CardAdapter.CardViewHolder> {
    private final List<Advertisement> advertisements;

    public CardAdapter(List<Advertisement> advertisements) {
        this.advertisements = advertisements;
    }

    @NonNull
    @Override
    public CardViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.advertisement_item_card, parent, false);
        return new CardViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull CardViewHolder holder, int position) {
        Advertisement advertisement = advertisements.get(position);

        holder.title.setText(advertisement.getTitle());
        holder.description.setText(advertisement.getDescription());

        holder.itemView.setOnClickListener(v -> {
            NavController navController = Navigation.findNavController(v);

            Bundle args = new Bundle();
            args.putString("ADVERTISEMENT_ID", String.valueOf(advertisement.getId()));

            navController.navigate(R.id.action_navigation_home_to_navigation_advertisement, args);
        });
    }

    @Override
    public int getItemCount() {
        return advertisements.size();
    }

    public static class CardViewHolder extends RecyclerView.ViewHolder {
        TextView title;
        TextView description;

        CardViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.text_card_title);
            description = itemView.findViewById(R.id.text_card_description);
        }
    }
}
