<?php

use hail812\adminlte\widgets\InfoBox;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];

/** @var int $totalReports */
/** @var int $totalUsers */
/** @var int $totalAdvertisements */
/** @var int $totalTrades */

?>
<div class="container-fluid">

    <div class="row">
        <?php if (Yii::$app->user->can('reviwer')): ?>
            <div class="col-md-3 col-sm-6 col-12">
                <?= InfoBox::widget([
                    'text' => 'Reports',
                    'number' => $totalReports,
                    'icon' => 'far fa-envelope',
                ]) ?>
            </div>

            <?php if (Yii::$app->user->can('admin')): ?>
                <div class="col-md-3 col-sm-6 col-12">
                    <?= InfoBox::widget([
                        'text' => 'Users',
                        'number' => $totalUsers,
                        'icon' => 'fas fa-users',
                    ]) ?>
                </div>
            <?php endif; ?>
        

            <div class="col-md-3 col-sm-6 col-12">
                <?= InfoBox::widget([
                    'text' => 'Advertisements',
                    'number' => $totalAdvertisements,
                    'icon' => 'fas fa-bullhorn',
                ]) ?>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <?= InfoBox::widget([
                    'text' => 'Trades',
                    'number' => $totalTrades,
                    'icon' => 'fas fa-exchange-alt',
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

</div>

