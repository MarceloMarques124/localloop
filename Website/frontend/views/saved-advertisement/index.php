<?php

use common\models\SavedAdvertisement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\SavedAdvertisementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Saved Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saved-advertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Saved Advertisement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_info_id',
            'advertisement_id',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SavedAdvertisement $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id]);
                 }
            ],
        ],
    ]); ?>


</div>
