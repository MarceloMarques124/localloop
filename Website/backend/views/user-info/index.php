<?php

use common\models\UserInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        /*         if (Yii::$app->user->can('admin')) { ?>
            <?= Html::a('Create User Info', ['create'], ['class' => 'btn btn-success']) ?>
        <?php }  */ ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'address',
            'postal_code',
            'flagged_for_ban',
            // Access User model properties directly
            'user.username',
            'user.email',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}{update}',
                'urlCreator' => function ($action, UserInfo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>