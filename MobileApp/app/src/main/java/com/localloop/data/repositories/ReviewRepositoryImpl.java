package com.localloop.data.repositories;

import com.localloop.api.repositories.ReviewRepository;
import com.localloop.api.services.ReviewApiService;
import com.localloop.data.models.Review;
import com.localloop.utils.DataCallBack;

import java.util.List;

import javax.inject.Inject;

public class ReviewRepositoryImpl extends BaseRepositoryImpl implements ReviewRepository {

    private final ReviewApiService apiService;

    @Inject
    public ReviewRepositoryImpl(ReviewApiService apiService) {
        this.apiService = apiService;
    }

    @Override
    public void getAllReviews(DataCallBack<List<Review>> callBack) {
        enqueueCall(apiService.getReviews(), callBack, "Failed to get reviews"); // FIX: Correct method
    }

    @Override
    public void fetchReview(int id, DataCallBack<Review> callBack) {
        enqueueCall(apiService.getReview(id), callBack, "Failed to fetch review");
    }

    @Override
    public void createReview(Review review, DataCallBack<Review> callBack) {
        enqueueCall(apiService.createReview(review), callBack, "Failed to create review");
    }

    @Override
    public void updateReview(int id, Review review, DataCallBack<Review> callBack) {
        enqueueCall(apiService.updateReview(id, review), callBack, "Failed to update review");
    }

    @Override
    public void deleteReview(int id, DataCallBack<Void> callBack) {
        enqueueCall(apiService.deleteReview(id), callBack, "Failed to delete review");
    }
}
