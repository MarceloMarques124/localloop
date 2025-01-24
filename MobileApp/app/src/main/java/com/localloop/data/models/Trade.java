package com.localloop.data.models;

import java.util.List;

public class Trade extends BaseModel {
    private int id;
    private int advertisementId;
    private int userInfoId;
    private int state;
    private List<TradeProposal> tradeProposals;
    private Advertisement advertisement;

    public Trade(int advertisementId) {
        this.advertisementId = advertisementId;
    }

    public Advertisement getAdvertisement() {
        return advertisement;
    }

    public void setAdvertisement(Advertisement advertisement) {
        this.advertisement = advertisement;
    }

    public List<TradeProposal> getTradeProposals() {
        return tradeProposals;
    }

    public void setTradeProposals(List<TradeProposal> tradeProposals) {
        this.tradeProposals = tradeProposals;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getAdvertisementId() {
        return advertisementId;
    }

    public void setAdvertisementId(int advertisementId) {
        this.advertisementId = advertisementId;
    }

    public int getUserInfoId() {
        return userInfoId;
    }

    public void setUserInfoId(int userInfoId) {
        this.userInfoId = userInfoId;
    }

    public int getState() {
        return state;
    }

    public void setState(int state) {
        this.state = state;
    }
}
