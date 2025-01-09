<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Trade $model */
/** @var yii\data\ActiveDataProvider $tradeProposal */


$this->title = 'Trade Info';
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
            [
                'attribute' => 'state',
                'value' => function ($model) {
                    return $model->state == 1 ? 'Active' : 'Closed';
                },
            ],
            'created_at',
        ],
    ]) ?>

    <h2>Trade Proposal Info</h2>

    <?= GridView::widget([
        'dataProvider' => $tradeProposalDataProvider,
        'columns' => [
            [
                'attribute' => 'state',
                'value' => function ($model) {
                    switch ($model->state) {
                        case 0:
                            return 'Pending'; // Estado 0
                        case 1:
                            return 'Accepted';  // Estado 1
                        case 2:
                            return 'Rejected';  // Estado 2
                        default:
                            return 'Unknown'; // Caso de erro ou estado desconhecido
                    }
                },
            ],
            'message',
            'created_at',
        ],
    ]); ?>

    <h2>Item Info</h2>


    <?= GridView::widget([
        'dataProvider' => $tradeProposalItemDataProvider,
        'columns' => [
            'item.name',
        ],
    ]); ?>



    <!-- Reviews Table -->
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $model->reviews,
            'pagination' => false, // Desabilitar a paginação se não precisar
        ]),
        'columns' => [
            [
                'attribute' => 'userInfo.name',
                'label' => 'Reviewer Name',
                'value' => function ($model) {
                    return Html::encode($model->userInfo->name);
                },
            ],
            'message',
            [
                'attribute' => 'stars',
                'label' => 'Stars',
                'value' => function ($model) {
                    return $model->stars . ' stars';
                },
            ],
            'created_at',
        ],
    ]); ?>
    <!-- Report button -->
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Report Trade', ['report/create', 'entityType' => 'trade', 'entityId' => $model->id], ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
    <!-- Add this section to allow the user to create a review after the trade is completed -->
    <?php if ($model->state == 1 && !\common\models\Review::find()->where(['trade_id' => $model->id, 'user_info_id' => Yii::$app->user->id])->exists()): ?>
        <?= Html::a('Leave a Review', ['review/create', 'trade_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>