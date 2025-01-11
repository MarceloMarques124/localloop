<?php

use common\models\Trade;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\TradeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Trades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'contentOptions' => ['style' => 'text-align:center;'],
                'urlCreator' => function ($action, Trade $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>