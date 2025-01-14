package com.localloop.ui.advertisement;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;

import java.util.List;

public class CarouselAdapter extends RecyclerView.Adapter<CarouselAdapter.CarouselViewHolder> {
    private final List<Integer> imageResources;

    public CarouselAdapter(List<Integer> imageResources) {
        this.imageResources = imageResources;
    }

    @NonNull
    @Override
    public CarouselViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_carousel_image, parent, false);
        return new CarouselViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull CarouselViewHolder holder, int position) {
        holder.bind(imageResources.get(position));
    }

    @Override
    public int getItemCount() {
        return imageResources.size();
    }

    static class CarouselViewHolder extends RecyclerView.ViewHolder {
        private final ImageView imageView;

        public CarouselViewHolder(@NonNull View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.carouselImage);
        }

        void bind(int imageResId) {
            imageView.setImageResource(imageResId);
        }
    }
}
