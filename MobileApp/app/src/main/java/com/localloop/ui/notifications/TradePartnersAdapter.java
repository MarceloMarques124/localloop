package com.localloop.ui.notifications;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.User;

import java.util.List;

public class TradePartnersAdapter extends RecyclerView.Adapter<TradePartnersAdapter.ViewHolder> {

    private final List<User> tradePartners;

    public TradePartnersAdapter(List<User> tradePartners) {
        this.tradePartners = tradePartners;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_message, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        User user = tradePartners.get(position);
        holder.textName.setText(user.getName());
        holder.textMessagePreview.setText(user.getEmail());

        holder.imageProfile.setImageResource(R.drawable.place_holder_image);
    }

    @Override
    public int getItemCount() {
        return tradePartners != null ? tradePartners.size() : 0;
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView imageProfile;
        TextView textName, textMessagePreview;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageProfile = itemView.findViewById(R.id.image_profile);
            textName = itemView.findViewById(R.id.text_name);
            textMessagePreview = itemView.findViewById(R.id.text_message_preview);
        }
    }
}
