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
        private final ImageView saveIcon;

        ViewHolder(View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.text_card_title);
            description = itemView.findViewById(R.id.text_card_description);
            saveIcon = itemView.findViewById(R.id.image_add);
        }

        void bind(Advertisement advertisement) {
            title.setText(advertisement.getTitle());
            description.setText(advertisement.getDescription());

            // Set save button onClickListener
            saveIcon.setOnClickListener(v -> callback.onSaveClicked(advertisement));

            // Set click on entire card to navigate
            itemView.setOnClickListener(v -> {
                // Get NavController directly from the context, which is safer for navigation
                NavController navController = Navigation.findNavController(itemView);

                // Bundle to pass data to next fragment
                Bundle bundle = new Bundle();
                bundle.putString("ADVERTISEMENT_ID", String.valueOf(advertisement.getId())); // pass data to next fragment

                // Navigate to the detailed fragment
                navController.navigate(R.id.action_navigation_home_to_navigation_advertisement, bundle);
            });
        }
    }
}