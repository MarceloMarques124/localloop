<?php

use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Reports';
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
                    return $model->userInfo ? $model->userInfo->name : 'No User Info';
                },
            ],
            [
                'attribute' => 'user_info_id',
                'label' => 'Reported User Name',
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->name : 'No User Info';
                },
            ],
            'created_at',
        ],
    ]); ?>


</div>
