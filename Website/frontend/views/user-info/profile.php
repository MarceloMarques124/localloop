<?php

use yii\helpers\Html;

$this->title = 'Perfil do Usuário';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-page">

    <!-- Informações do Usuário -->
    <div class="user-info mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Exibe uma imagem de perfil, com fallback -->
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title"><?= Html::encode($userInfo->name) ?></h2>
                            <a href="<?= \yii\helpers\Url::to(['report/create', 'entityType' => 'user', 'entityId' => $userInfo->id]) ?>" class="btn btn-danger btn-sm">
                                Reportar
                            </a>
                        </div>
                        <p class="card-text">
                            <strong>Email:</strong> <?= Html::encode($userInfo->user->email) ?><br>
                            <strong>Address:</strong> <?= Html::encode($userInfo->address) ?><br>
                            <strong>Postal-code:</strong> <?= Html::encode($userInfo->postal_code) ?><br>
                            <strong>Member since:</strong> <?= Yii::$app->formatter->asDate($userInfo->created_at) ?>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                Última atualização do perfil: <?= Yii::$app->formatter->asRelativeTime($userInfo->updated_at) ?>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Anúncios do Usuário -->
    <div class="user-advertisements">
        <h3>Anúncios de <?= Html::encode($userInfo->name) ?></h3>
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
                                                Criado <?= Yii::$app->formatter->asRelativeTime($advertisement->created_at) ?>
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

<style>
    .user-info {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
    }

    .user-info img {
        max-width: 100px;
        height: auto;
        border-radius: 50%;
    }

    .user-info h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card img {
        max-width: 100%;
        height: auto;
        border-radius: 10px 0 0 10px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>