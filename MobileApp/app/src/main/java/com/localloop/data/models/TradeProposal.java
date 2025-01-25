package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class TradeProposal extends BaseModel {
    private List<TradeProposalItem> tradeProposalItems;
    private Trade trade;
    private int id;
    @SerializedName("trade_id")
    private int tradeId;
    private int state;
    private String message;

    public Trade getTrade() {
        return trade;
    }

    public void setTrade(Trade trade) {
        this.trade = trade;
    }

    public List<TradeProposalItem> getTradeProposalItems() {
        return tradeProposalItems;
    }

    public void setTradeProposalItems(List<TradeProposalItem> tradeProposalItems) {
        this.tradeProposalItems = tradeProposalItems;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getTradeId() {
        return tradeId;
    }

    public void setTradeId(int tradeId) {
        this.tradeId = tradeId;
    }

    public int getState() {
        return state;
    }

    public void setState(int state) {
        this.state = state;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
