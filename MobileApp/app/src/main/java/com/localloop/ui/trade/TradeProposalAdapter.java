package com.localloop.ui.trade;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.localloop.R;
import com.localloop.data.models.TradeProposal;

import java.util.List;

public class TradeProposalAdapter extends RecyclerView.Adapter<TradeProposalAdapter.TradeProposalViewHolder> {

    private final List<TradeProposal> proposalList;

    public TradeProposalAdapter(List<TradeProposal> proposalList) {
        this.proposalList = proposalList;
    }

    @NonNull
    @Override
    public TradeProposalViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_proposal, parent, false);
        return new TradeProposalViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull TradeProposalViewHolder holder, int position) {
        TradeProposal proposal = proposalList.get(position);

        holder.userNameTextView.setText(proposal.getUserName());
        holder.tradeProposalMessageTextView.setText(proposal.getMessage());

        switch (proposal.getState()) {
            case PENDING:
                holder.statusText.setText(R.string.PENDING);
                holder.statusIndicator.setBackgroundColor(holder.itemView.getContext().getColor(R.color.pendingColor));
                break;
            case REJECTED:
                holder.statusText.setText(R.string.REJECTED);
                holder.statusIndicator.setBackgroundColor(holder.itemView.getContext().getColor(R.color.rejectedColor));
                break;
            case ACCEPTED:
                holder.statusText.setText(R.string.ACCEPTED);
                holder.statusIndicator.setBackgroundColor(holder.itemView.getContext().getColor(R.color.acceptedColor));
                break;
            default:
                throw new IllegalStateException("Unexpected value: " + proposal.getState());
        }

        TradeProposalItemAdapter itemAdapter = new TradeProposalItemAdapter(proposal.getTradeProposalItems());
        holder.imagesRecyclerView.setLayoutManager(new GridLayoutManager(holder.itemView.getContext(), 3));
        holder.imagesRecyclerView.setAdapter(itemAdapter);
    }

    @Override
    public int getItemCount() {
        return proposalList != null ? proposalList.size() : 0;
    }

    public static class TradeProposalViewHolder extends RecyclerView.ViewHolder {

        TextView userNameTextView;
        TextView tradeProposalMessageTextView;
        RecyclerView imagesRecyclerView;
        View statusIndicator;
        TextView statusText;

        public TradeProposalViewHolder(View itemView) {
            super(itemView);

            userNameTextView = itemView.findViewById(R.id.userName);
            tradeProposalMessageTextView = itemView.findViewById(R.id.tradeProposalMessage);
            imagesRecyclerView = itemView.findViewById(R.id.recycler_view);
            statusIndicator = itemView.findViewById(R.id.status_indicator);
            statusText = itemView.findViewById(R.id.status_text);

        }
    }
}