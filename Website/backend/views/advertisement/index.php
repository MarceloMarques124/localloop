<?php

use common\models\Advertisement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\AdvertisementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width:5%;'], // Define a largura da coluna
            ],

            [
                'attribute' => 'userInfo.name',
                'contentOptions' => ['style' => 'width:5%;'], // Define a largura da coluna
            ],

            [
                'attribute' => 'title',
                'contentOptions' => ['style' => 'width:15%;'], // Define a largura da coluna
            ],

            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'width:30%;'], // Define a largura da coluna
            ],

            [
                'attribute' => 'is_service', // Nome do atributo no modelo
                'contentOptions' => ['style' => 'width:3%; text-align:center;'], // Define a largura da coluna
                'value' => function ($model) {
                    return $model->is_service == 1 ? 'Yes' : 'No'; // Retorna "Yes" ou "No"
                },
            ],

            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'width:8%; text-align:center;'], // Define a largura da coluna
                'urlCreator' => function ($action, Advertisement $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>