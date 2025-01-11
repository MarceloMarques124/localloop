<?php

use yii\helpers\Html;

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-page">

    <div class="user-info mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title"><?= Html::encode($userInfo->name) ?></h2>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <a href="<?= \yii\helpers\Url::to(['report/create', 'entityType' => 'user', 'entityId' => $userInfo->id]) ?>" class="btn btn-danger btn-sm">
                                    Report
                                </a>
                            <?php endif; ?>
                        </div>
                        <p class="card-text">
                            <strong>Email:</strong> <?= Html::encode($userInfo->user->email) ?><br>
                            <strong>Address:</strong> <?= Html::encode($userInfo->address) ?><br>
                            <strong>Postal-code:</strong> <?= Html::encode($userInfo->postal_code) ?><br>
                            <strong>Member since:</strong> <?= Yii::$app->formatter->asDate($userInfo->created_at) ?>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                Last profile update: <?= Yii::$app->formatter->asRelativeTime($userInfo->updated_at) ?>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Anúncios do Usuário -->
    <div class="user-advertisements">
        <h3>Advertisements of <?= Html::encode($userInfo->name) ?></h3>
        <div class="row">
            <?php foreach ($userAdvertisements as $advertisement): ?>
                <div class="col-lg-4 mb-4">
                    <a href="<?= \yii\helpers\Url::to(['advertisement/page', 'id' => $advertisement->id]) ?>" class="card-click">
                        <div class="card h-100">
                            <div class="row g-0">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"><?= Html::encode($advertisement->title) ?></h5>
                                        <p class="card-text text-truncate"><?= Html::encode($advertisement->description) ?></p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Create <?= Yii::$app->formatter->asRelativeTime($advertisement->created_at) ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>