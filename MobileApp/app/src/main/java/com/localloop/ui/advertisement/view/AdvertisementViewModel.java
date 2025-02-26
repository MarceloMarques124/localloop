package com.localloop.ui.advertisement.view;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.localloop.api.repositories.AdvertisementRepository;
import com.localloop.api.repositories.CartRepository;
import com.localloop.api.repositories.CurrentUserRepository;
import com.localloop.api.repositories.ReportRepository;
import com.localloop.data.models.Advertisement;
import com.localloop.data.models.Report;
import com.localloop.data.models.User;
import com.localloop.ui.BaseViewModel;
import com.localloop.utils.DataCallBack;

import java.time.LocalDateTime;

import javax.inject.Inject;

import dagger.hilt.android.lifecycle.HiltViewModel;

@HiltViewModel
public class AdvertisementViewModel extends BaseViewModel {

    private final ReportRepository reportRepository;


    private final MutableLiveData<String> description = new MutableLiveData<>();
    private final MutableLiveData<String> title = new MutableLiveData<>();
    private final MutableLiveData<LocalDateTime> advertisementCreatedDate = new MutableLiveData<>();
    private final MutableLiveData<Float> rating = new MutableLiveData<>();
    private final MutableLiveData<LocalDateTime> accountCreatedAt = new MutableLiveData<>();
    private final MutableLiveData<String> buttonText = new MutableLiveData<>();
    private final MutableLiveData<Boolean> hasProposal = new MutableLiveData<>();
    private final MutableLiveData<User> userMutableLiveData = new MutableLiveData<>();
    private final MutableLiveData<Boolean> isOnCart = new MutableLiveData<>(false);
    private final AdvertisementRepository advertisementRepository;
    private final CurrentUserRepository currentUserRepository;
    private final CartRepository cartRepository;
    private Advertisement advertisement;

    @Inject
    public AdvertisementViewModel(AdvertisementRepository advertisementRepository,
                                  ReportRepository reportRepository,
                                  CurrentUserRepository currentUserRepository,
                                  CartRepository cartRepository) {
        this.advertisementRepository = advertisementRepository;
        this.reportRepository = reportRepository;
        this.currentUserRepository = currentUserRepository;
        this.cartRepository = cartRepository;
    }

    public LiveData<Boolean> getIsOnCart() {
        return isOnCart;
    }

    public void getAdvertisement(int id) {
        advertisementRepository.fetchAdvertisement(id, new DataCallBack<>() {
            @Override
            public void onSuccess(Advertisement advertisement) {
                updateData(advertisement);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    private void getCurrentUser() {
        currentUserRepository.getUser(new DataCallBack<User>() {
            @Override
            public void onSuccess(User user) {
                userMutableLiveData.setValue(user);
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    private void updateData(Advertisement advertisement) {
        setAdvertisement(advertisement);

        getCurrentUser();

        description.setValue(advertisement.getDescription());
        title.setValue(advertisement.getTitle());
        advertisementCreatedDate.setValue(advertisement.getCreatedAt());
        rating.setValue(advertisement.getUser().getAverageStars());
        accountCreatedAt.setValue(advertisement.getUser().getCreatedAt());
        hasProposal.setValue(advertisement.getCurrentUserTrade() != null);
        isOnCart.setValue(advertisement.getOnCart());
    }

    public LiveData<User> getUserMutableLiveData() {
        return userMutableLiveData;
    }

    public Advertisement getAdvertisement() {
        return advertisement;
    }

    public void setAdvertisement(Advertisement advertisement) {
        this.advertisement = advertisement;
    }

    public LiveData<Boolean> getHasProposal() {
        return hasProposal;
    }

    public void setHasProposal(boolean hasProposal) {
        this.hasProposal.setValue(hasProposal);
    }

    public LiveData<String> getDescription() {
        return description;
    }

    public LiveData<String> getTitle() {
        return title;
    }

    public LiveData<LocalDateTime> getAdvertisementCreatedDate() {
        return advertisementCreatedDate;
    }

    public LiveData<Float> getRating() {
        return rating;
    }

    public LiveData<LocalDateTime> getAccountCreatedAt() {
        return accountCreatedAt;
    }

    public LiveData<String> getButtonText() {
        return buttonText;
    }

    public void setButtonText(String text) {
        this.buttonText.setValue(text);
    }

    public void reportAdvertisement(String reason, int advertisementId) {
        reportRepository.insertReport("advertisement", advertisementId, new DataCallBack<Report>() {
            @Override
            public void onSuccess(Report report) {
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }

    public void toggleCartItem(int advertisementId) {
        cartRepository.toggleCartItem(advertisementId, new DataCallBack<>() {
            @Override
            public void onSuccess(Void data) {
                isOnCart.setValue(Boolean.FALSE.equals(isOnCart.getValue()));
            }

            @Override
            public void onError(String errorMessage) {
                error.setValue(errorMessage);
            }
        });
    }
}
