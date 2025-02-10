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
import com.localloop.api.responses.TradeResponse;
import com.localloop.utils.ArgumentKeys;

import java.util.List;

public class TradesAdapter extends RecyclerView.Adapter<TradesAdapter.ViewHolder> {

    private List<TradeResponse> trades;

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.trade_message, parent, false);
        return new ViewHolder(view);
    }

    public void updateList(List<TradeResponse> trades) {
        this.trades = trades;
        notifyDataSetChanged();
    }


    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        TradeResponse trade = trades.get(position);
        holder.advertisementTitle.setText(trade.getAdvertisementTitle());
        holder.lastProposalMessage.setText(trade.getLastProposalMessage());

        holder.imageProfile.setImageResource(R.drawable.place_holder_image);

        holder.itemView.setOnClickListener(v -> {
            NavController navController = Navigation.findNavController(v);

            Bundle args = new Bundle();
            args.putString(ArgumentKeys.TRADE_ID, String.valueOf(trade.getTradeId()));

            navController.navigate(R.id.action_navigation_notifications_to_navigation_trade, args);
        });
    }

    @Override
    public int getItemCount() {
        return trades != null ? trades.size() : 0;
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView imageProfile;
        TextView advertisementTitle;
        TextView lastProposalMessage;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageProfile = itemView.findViewById(R.id.image_profile);
            advertisementTitle = itemView.findViewById(R.id.advertisement_title);
            lastProposalMessage = itemView.findViewById(R.id.last_proposal_message);
        }
    }
}
