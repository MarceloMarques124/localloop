<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Trade $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="trade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'advertisement.title',
                'label' => 'Advertisement title',
            ],
            'userInfo.name',
            [
                'attribute' => 'state', // Nome do atributo no modelo
                'value' => function ($model) {
                    return $model->state == 1 ? 'Active' : 'Close';
                },
            ],
            'created_at',
        ],
    ]) ?>

</div>