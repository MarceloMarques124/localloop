<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Report $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'author.name',
                'label' => 'Author name',
            ],
            [
                'attribute' => 'userInfo.name',
                'label' => 'User reported',
            ],
            [
                'attribute' => 'trade.advertisement.title',
                'label' => 'Trade reported',
            ],
            [
                'attribute' => 'advertisement.title',
                'label' => 'Advertisement reported',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>