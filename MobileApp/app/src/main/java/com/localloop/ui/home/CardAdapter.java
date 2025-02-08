package com.localloop.ui.home;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.Advertisement;
import com.localloop.utils.ArgumentKeys;

import java.util.List;

public class CardAdapter extends RecyclerView.Adapter<CardAdapter.ViewHolder> {

    private final List<Advertisement> advertisements;
    private final SaveAdvertisementCallback callback;

    public CardAdapter(List<Advertisement> advertisements, SaveAdvertisementCallback callback) {
        this.advertisements = advertisements;
        this.callback = callback;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.advertisement_item_card, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Advertisement advertisement = advertisements.get(position);
        holder.bind(advertisement);
    }


    @Override
    public int getItemCount() {
        return advertisements.size();
    }

    public interface SaveAdvertisementCallback {
        void onSaveClicked(Advertisement advertisement);
    }

    class ViewHolder extends RecyclerView.ViewHolder {

        private final TextView title, description;
        private final ImageView favoriteIcon;

        ViewHolder(View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.text_card_title);
            description = itemView.findViewById(R.id.text_card_description);
            favoriteIcon = itemView.findViewById(R.id.favorite_icon);
        }

        void bind(Advertisement advertisement) {
            title.setText(advertisement.getTitle());
            description.setText(advertisement.getDescription());

            if (Boolean.TRUE.equals(advertisement.getSaved())) {
                favoriteIcon.setImageResource(R.drawable.baseline_favorite_24);
            } else {
                favoriteIcon.setImageResource(R.drawable.baseline_favorite_border_24);
            }

            favoriteIcon.setOnClickListener(v -> callback.onSaveClicked(advertisement));


            itemView.setOnClickListener(v -> {
                NavController navController = Navigation.findNavController(itemView);

                Bundle bundle = new Bundle();
                bundle.putString(ArgumentKeys.ADVERTISEMENT_ID, String.valueOf(advertisement.getId())); // pass data to next fragment

                navController.navigate(R.id.action_navigation_home_to_navigation_advertisement, bundle);
            });
        }
    }
}