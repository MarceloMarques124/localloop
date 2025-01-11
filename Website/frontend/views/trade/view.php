<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
    <?= GridView::widget([
        'dataProvider' => $tradeDataProvider,
        'columns' => [
            [
                'attribute' => 'advertisement.title',
                'label' => 'Advertisement title',
            ],
            'created_at',

        ],
    ]) ?>

    <h2>Trade Proposal Info</h2>

    <?= GridView::widget([
        'dataProvider' => $tradeProposalDataProvider,
        'columns' => [
            'message',
            [
                'attribute' => 'state',
                'value' => function ($model) {
                    if ($model->state == 1) {
                        return 'Accepted';
                    } elseif ($model->state == 0) {
                        return 'Open';
                    } else {
                        return 'Rejected';
                    }
                },
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{accept} {reject}', // Define os botões customizados
                'buttons' => [
                    'accept' => function ($url, $model, $key) use ($tradeDataProvider) {
                        // Verifica se o user_info_id é diferente do usuário logado
                        $trade = $tradeDataProvider->getModels()[0]; // Assume que há apenas um trade relacionado
                        if ($trade->user_info_id != Yii::$app->user->id && $trade->state == 1) {
                            return Html::a('Accept', ['trade-proposal/update-state', 'id' => $model->id, 'state' => 1], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Want accept this proposal?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        return ''; // Não exibe o botão se for o próprio usuário
                    },
                    'reject' => function ($url, $model, $key) use ($tradeDataProvider) {
                        // Verifica se o user_info_id é diferente do usuário logado
                        $trade = $tradeDataProvider->getModels()[0]; // Assume que há apenas um trade relacionado
                        if ($trade->user_info_id != Yii::$app->user->id && $trade->state == 1) {
                            return Html::a('Reject', ['trade-proposal/update-state', 'id' => $model->id, 'state' => 2], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Want reject this proposal?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>

    <h2>Item Info</h2>

    <?= GridView::widget([
        'dataProvider' => $tradeProposalItemDataProvider,
        'columns' => [
            'item.name',
        ],
    ]); ?>

    <h2>Review Info</h2>

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
    <?php foreach ($tradeProposalDataProvider->getModels() as $tradeProposal): ?>
        <?php if ($tradeProposal->state == 1 || $tradeProposal->state == 2): ?>
            <?php foreach ($tradeDataProvider->getModels() as $trade): ?>
                <?php $tradeUserId = $trade->user_info_id ?>
                <?php if (!Yii::$app->user->isGuest && !\common\models\Report::find()->where(['author_id' => Yii::$app->user->id, 'trade_id' => $trade->id])->exists()): ?>
                    <?= Html::a('Report Trade', ['report/create', 'entityType' => 'trade', 'entityId' => $model->id], ['class' => 'btn btn-danger']) ?>
                <?php endif; ?>

            <?php endforeach; ?>
            <?php if ($tradeUserId == Yii::$app->user->id): ?>
                <?php if ($model->state == 0 && !\common\models\Review::find()->where(['trade_id' => $model->id, 'user_info_id' => Yii::$app->user->id])->exists()): ?>
                    <?= Html::a('Leave a Review', ['review/create', 'trade_id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>