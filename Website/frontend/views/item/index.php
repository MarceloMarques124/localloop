<?php

use common\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\ItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="body-content">
    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <?php foreach ($userItems as $userItem): ?>
            <div class="col-lg-4">
                <a href="<?= \yii\helpers\Url::to(['item/view', 'id' => $userItem->id]) ?>" class="card-click">
                    <div class="card mb-3 card-fixed-size" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php /* \yii\helpers\Html::encode($advertisement->image_url) */ ?>" class="img-fluid rounded-start" alt="<?= \yii\helpers\Html::encode($userItem->name) ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate"><?= \yii\helpers\Html::encode($userItem->name) ?></h5>
                                    <h5 class="card-title multi-line"><?= \yii\helpers\Html::encode($userItem->subCategory->name) ?></h5>
                                    <p class="card-text multi-line"><small class="text-body-secondary">Created <?= Yii::$app->formatter->asRelativeTime($userItem->created_at) ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Define a altura fixa dos cartões */
    .card-fixed-size {
        height: 220px;
        /* Altere conforme necessário */
        overflow: hidden;
    }

    /* Trunca o texto com reticências (...) */
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .multi-line {
        min-height: 100px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        /* Limite de linhas antes de truncar */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>