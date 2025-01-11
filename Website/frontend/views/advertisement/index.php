<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <div class="row">
            <?php foreach ($dataProvider->models as $advertisement): ?>
                <div class="col-lg-4">
                    <a href="<?= Url::to(['advertisement/view', 'id' => $advertisement->id]) ?>" class="card-click">
                        <div class="card mb-3 card-fixed-size" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php /* Html::encode($advertisement->image_url) */ ?>" class="img-fluid rounded-start" alt="<?php /* Html::encode($advertisement->title) */ ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"><?= Html::encode($advertisement->title) ?></h5>
                                        <p class="card-text multi-line"> <?= Html::encode($advertisement->description) ?></p>
                                        <p class="card-text multi-line"> <?= Html::encode($advertisement->updated_at) ?></p>
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