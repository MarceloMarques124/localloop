package com.localloop.ui.proposal;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.Item;

import java.util.ArrayList;
import java.util.List;

public class MakeProposalDrawerAdapter extends RecyclerView.Adapter<MakeProposalDrawerAdapter.ViewHolder> {

    private final List<Item> items;
    private final List<Item> selectedItems = new ArrayList<>();

    public MakeProposalDrawerAdapter(List<Item> items) {
        this.items = items;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_proposal_drawer, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Item item = items.get(position);

        holder.imageView.setImageResource(R.drawable.place_holder_image);

        boolean isSelected = selectedItems.contains(item);
        holder.itemView.setSelected(isSelected);
        holder.selectedIcon.setVisibility(isSelected ? View.VISIBLE : View.GONE);

        holder.itemView.setOnClickListener(v -> {
            if (selectedItems.contains(item)) {
                selectedItems.remove(item);
                holder.itemView.setSelected(false);
                holder.selectedIcon.setVisibility(View.GONE);
            } else {
                selectedItems.add(item);
                holder.itemView.setSelected(true);
                holder.selectedIcon.setVisibility(View.VISIBLE);
            }
        });
    }

    @Override
    public int getItemCount() {
        return items.size();
    }

    public List<Item> getSelectedItems() {
        return selectedItems;
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView imageView;
        ImageView selectedIcon;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.item_image);
            selectedIcon = itemView.findViewById(R.id.selected_icon);
        }
    }
}
