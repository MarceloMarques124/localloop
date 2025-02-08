package com.localloop.ui.notifications;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.User;

import java.util.List;

public class TradePartnersAdapter extends RecyclerView.Adapter<TradePartnersAdapter.ViewHolder> {

    private List<User> tradePartners;

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

    public void updateList(List<User> newList) {
        this.tradePartners = newList;
        notifyDataSetChanged();
    }


    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        User user = tradePartners.get(position);
        holder.textName.setText(user.getName());
        holder.textMessagePreview.setText(user.getEmail());

        holder.imageProfile.setImageResource(R.drawable.place_holder_image);

        holder.itemView.setOnClickListener(v -> {
            NavController navController = Navigation.findNavController(v);

            Bundle args = new Bundle();
//            args.putString(ArgumentKeys.TRADE_ID, String.valueOf(user.get));

            navController.navigate(R.id.action_navigation_notifications_to_navigation_trade, args);
        });
    }

    @Override
    public int getItemCount() {
        return tradePartners != null ? tradePartners.size() : 0;
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView imageProfile;
        TextView textName;
        TextView textMessagePreview;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageProfile = itemView.findViewById(R.id.image_profile);
            textName = itemView.findViewById(R.id.text_name);
            textMessagePreview = itemView.findViewById(R.id.text_message_preview);
        }
    }
}
