package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

public class TradeProposalItem extends BaseModel {
    @SerializedName("trade_proposal_id")
    private int tradeProposalId;
    @SerializedName("item_id")

    private int itemId;
    private TradeProposal tradeProposal;
    private Item item;

    public TradeProposalItem(int tradeProposalId, int itemId) {
        this.tradeProposalId = tradeProposalId;
        this.itemId = itemId;
    }

    public Item getItem() {
        return item;
    }

    public void setItem(Item item) {
        this.item = item;
    }

    public TradeProposal getTradeProposal() {
        return tradeProposal;
    }

    public void setTradeProposal(TradeProposal tradeProposal) {
        this.tradeProposal = tradeProposal;
    }

    public int getTradeProposalId() {
        return tradeProposalId;
    }

    public void setTradeProposalId(int tradeProposalId) {
        this.tradeProposalId = tradeProposalId;
    }

    public int getItemId() {
        return itemId;
    }

    public void setItemId(int itemId) {
        this.itemId = itemId;
    }
}
