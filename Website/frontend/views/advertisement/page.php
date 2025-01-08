<?php

use yii\helpers\Html;

$this->title = 'Adevertisement Details';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="advertisement-page container-fluid">
    <div class="container my-4 p-4 bg-white shadow rounded">
        <!-- Título principal -->
        <div class="text-center mb-4 border-bottom pb-2">
            <h1 class="h3"><?= Html::encode($this->title) ?></h1>
        </div>

        <!-- Seções de Informação -->
        <div class="row g-4">
            <!-- Informação do Anúncio -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded shadow-sm">
                    <h2 class="h5">Adevertisement details</h2>
                    <p><span class="fw-bold"></span> <?= Html::encode($advertisement->title)
                                                        ?></p>
                    <p><span class="fw-bold">Description:</span> <?= Html::encode($advertisement->description)
                                                                    ?></p>
                    <p><span class="fw-bold">Service/Item:</span> <?= $advertisement->is_service == 1 ? 'Service' : 'Item'
                                                                    ?></p>
                </div>
            </div>

            <!-- Informação do Anunciante -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded shadow-sm">
                    <h2 class="h5">Advertiser information</h2>
                    <p><span class="fw-bold">Announced by:</span> <?= Html::encode($userInfo->name)
                                                                    ?></p>
                    <p><span class="fw-bold">Address:</span> <?= Html::encode($userInfo->address)
                                                                ?></p>
                    <p><span class="fw-bold">Postal-Code:</span> <?= Html::encode($userInfo->postal_code)
                                                                    ?></p>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="mt-4 text-center">
            <?= Html::a('Trade item', ['trade-proposal/create', 'advertisementId' => $advertisement->id], ['class' => 'btn btn-primary mx-2']) ?>
            <?php if (!$savedAdvertisement) { ?>
                <?= Html::a('❤️ Add to Favorites', ['saved-advertisement/create', 'advertisement_id' => $advertisement->id], ['class' => 'btn btn-outline-danger mx-2']) ?>
            <?php } else { ?>
                <?= Html::a('❤️ Remove from Favorites', ['saved-advertisement/create', 'advertisement_id' => $advertisement->id], ['class' => 'btn btn-outline-danger mx-2']) ?>
            <?php } ?>
            <?= Html::a('Report advertisement', ['report/create', 'entityType' => 'advertisement', 'entityId' => $advertisement->id], ['class' => 'btn btn-danger mx-2']) ?>
            <?= Html::a('Advertiser profile', ['user-info/profile', 'userInfoId' => $userInfo->id], ['class' => 'btn btn-secondary mx-2']) ?>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .advertisement-page {
        padding-top: 70px;
        /* Garante espaço abaixo da navbar */
    }

    .container {
        max-width: 1200px;
    }

    .bg-white {
        background-color: #fff !important;
    }

    .shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .shadow-sm {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .rounded {
        border-radius: 10px !important;
    }

    .p-4 {
        padding: 1.5rem !important;
    }

    .p-3 {
        padding: 1rem !important;
    }

    .h3,
    .h5 {
        color: #333;
    }

    .fw-bold {
        font-weight: bold;
    }

    .text-center {
        text-align: center !important;
    }

    .border-bottom {
        border-bottom: 1px solid #ddd !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
    }
</style>