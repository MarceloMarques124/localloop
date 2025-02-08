package com.localloop.api.responses;

import com.localloop.data.models.Advertisement;
import com.localloop.data.models.Item;
import com.localloop.data.models.User;

import java.util.List;

public class UserProfile {
    private User user;
    private List<Item> items;
    private List<Advertisement> advertisements;

    public UserProfile(User user, List<Item> items, List<Advertisement> advertisements) {
        this.user = user;
        this.items = items;
        this.advertisements = advertisements;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public List<Item> getItems() {
        return items;
    }

    public void setItems(List<Item> items) {
        this.items = items;
    }

    public List<Advertisement> getAdvertisements() {
        return advertisements;
    }

    public void setAdvertisements(List<Advertisement> advertisements) {
        this.advertisements = advertisements;
    }
}
