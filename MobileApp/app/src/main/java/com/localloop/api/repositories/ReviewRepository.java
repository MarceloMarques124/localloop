package com.localloop.api.repositories;

import com.localloop.data.models.Review;
import com.localloop.utils.DataCallBack;

import java.util.List;

public interface ReviewRepository {
    void getAllReviews(final DataCallBack<List<Review>> callBack);

    void fetchReview(int id, final DataCallBack<Review> callBack);

    void createReview(Review review, DataCallBack<Review> callBack);

    void updateReview(int id, Review review, DataCallBack<Review> callBack);

    void deleteReview(int id, DataCallBack<Void> callBack);
}