package com.localloop.data.models;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class TradeProposal extends BaseModel {
    @SerializedName("trade_proposal_items")
    private List<TradeProposalItem> tradeProposalItems;
    private Trade trade;
    private int id;
    @SerializedName("trade_id")
    private int tradeId;
    private int state;
    private String message;
    @SerializedName("user_id")
    private int userId;
    @SerializedName("user_name")
    private String userName;

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

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

    public State getState() {
        return State.fromValue(this.state);
    }

    public void setState(State state) {
        this.state = state.getValue();
    }


    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public enum State {
        PENDING(0),
        REJECTED(1),
        ACCEPTED(2);

        private final int value;

        State(int value) {
            this.value = value;
        }

        public static State fromValue(int value) {
            for (State state : State.values()) {
                if (state.value == value) {
                    return state;
                }
            }
            throw new IllegalArgumentException("Invalid value: " + value);
        }

        public int getValue() {
            return value;
        }
    }
}
