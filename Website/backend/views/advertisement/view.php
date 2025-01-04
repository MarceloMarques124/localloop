<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Advertisement $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="advertisement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userInfo.name',
            'title',
            'description',
            [
                'attribute' => 'is_service', // Nome do atributo no modelo
                'value' => function ($model) {
                    return $model->is_service == 1 ? 'Yes' : 'No'; // Retorna "Yes" ou "No"
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>