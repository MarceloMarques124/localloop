package com.example.localloop.ui.home;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.localloop.R;
import com.example.localloop.models.Advertisement;

import java.util.List;

public class CardAdapter extends RecyclerView.Adapter<CardAdapter.CardViewHolder> {
    private final List<Advertisement> data;

    public CardAdapter(List<Advertisement> data) {
        this.data = data;
    }

    @NonNull
    @Override
    public CardViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_card, parent, false);
        return new CardViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull CardViewHolder holder, int position) {
        Advertisement advertisement = data.get(position);

        holder.title.setText(advertisement.getUserId() + advertisement.getCreatedDate().toString());
        holder.description.setText(advertisement.getDescription());
    }

    @Override
    public int getItemCount() {
        return data.size();
    }

    static class CardViewHolder extends RecyclerView.ViewHolder {
        TextView title;
        TextView description;

        CardViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.text_card_title);
            description = itemView.findViewById(R.id.text_card_description);
        }
    }
}
