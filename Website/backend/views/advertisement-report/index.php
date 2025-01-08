<?php

use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Advertisement Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'author_id',
                'label' => 'User Name',
                'value' => function ($model) {
                    return $model->author ? $model->author->name : 'No User Info';
                },
            ],
            [
                'attribute' => 'advertisement_id',
                'label' => 'Reported Advertisement',
                'value' => function ($model) {
                    return $model->advertisement ? $model->advertisement->title : 'No Advertisement';
                },
            ],
            'created_at',
        ],
    ]); ?>


</div>
