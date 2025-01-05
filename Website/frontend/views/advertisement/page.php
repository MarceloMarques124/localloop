<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-actions">
    <!-- Trade link -->
    <?= Html::a('Trade', ['trade-proposal/create', 'advertisementId' => $model->id], ['class' => 'btn btn-primary']) ?>

    <!-- Save to favorites link -->
    <?= Html::a('❤️ Favorite', ['saved-advertisement/create', 'advertisement_id' => $model->id], ['class' => 'btn btn-outline-danger']) ?>

    <!-- Report Advertisement button -->
    <?= Html::a('Report Advertisement', ['report/create', 'entityType' => 'advertisement', 'entityId' => $model->id], ['class' => 'btn btn-danger']) ?>
</div>