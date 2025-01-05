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

    <!-- Add this section to allow the user to create a review after the trade is completed -->
    <?php if ($model->state == 1 && !\common\models\Review::find()->where(['trade_id' => $model->id, 'user_info_id' => Yii::$app->user->id])->exists()): ?>
        <?= Html::a('Leave a Review', ['review/create', 'trade_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>

    <h3>Reviews</h3>
    <ul>
        <?php foreach ($model->reviews as $review): ?>
            <li><strong><?= Html::encode($review->userInfo->name) ?>:</strong> <?= Html::encode($review->message) ?> (<?= $review->stars ?> stars)</li>
        <?php endforeach; ?>
    </ul>
</div>