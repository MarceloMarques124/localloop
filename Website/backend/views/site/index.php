<?php

use hail812\adminlte\widgets\InfoBox;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];

/** @var int $totalReports */
/** @var int $totalUsers */
/** @var int $totalAdvertisements */
/** @var int $totalTrades */
/** @var int $totalTradesToday */
/** @var int $totalTradesOpen */
/** @var int $totalUsersReported */
/** @var int $totalAdvertisementsReported */
/** @var int $totalTradesReported */

?>
<div class="container-fluid">

    <h1 class="mb-4"><?= $this->title ?></h1>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Total Reports',
                'number' => $totalReports,
                'icon' => 'fas fa-flag',
                'theme' => 'warning',
            ]) ?>
        </div>

        <?php if (Yii::$app->user->can('admin')): ?>
            <div class="col-md-3 col-sm-6 col-12">
                <?= InfoBox::widget([
                    'text' => 'Total Users',
                    'number' => $totalUsers,
                    'icon' => 'fas fa-users',
                    'theme' => 'primary',
                ]) ?>
            </div>
        <?php endif; ?>

        <div class="col-md-3 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Total Advertisements',
                'number' => $totalAdvertisements,
                'icon' => 'fas fa-ad',
                'theme' => 'success',
            ]) ?>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Total Trades',
                'number' => $totalTrades,
                'icon' => 'fas fa-handshake',
                'theme' => 'info',
            ]) ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 col-sm-12">
            <?= InfoBox::widget([
                'text' => 'Trades Today',
                'number' => $totalTradesToday,
                'icon' => 'fas fa-calendar-day',
                'theme' => 'primary',
            ]) ?>
        </div>

        <div class="col-md-6 col-sm-12">
            <?= InfoBox::widget([
                'text' => 'Open Trades',
                'number' => $totalTradesOpen,
                'icon' => 'fas fa-folder-open',
                'theme' => 'info',
            ]) ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 col-sm-12">
            <?= InfoBox::widget([
                'text' => 'Users Reported',
                'number' => $totalUsersReported,
                'icon' => 'fas fa-user-times',
                'theme' => 'danger',
            ]) ?>
        </div>

        <div class="col-md-4 col-sm-12">
            <?= InfoBox::widget([
                'text' => 'Advertisements Reported',
                'number' => $totalAdvertisementsReported,
                'icon' => 'fas fa-ban',
                'theme' => 'warning',
            ]) ?>
        </div>

        <div class="col-md-4 col-sm-12">
            <?= InfoBox::widget([
                'text' => 'Trades Reported',
                'number' => $totalTradesReported,
                'icon' => 'fas fa-exclamation-triangle',
                'theme' => 'danger',
            ]) ?>
        </div>
    </div>
</div>