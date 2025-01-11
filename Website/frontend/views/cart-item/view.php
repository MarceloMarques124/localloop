<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CartItem $model */

$this->title = $model->cart_id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cart-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cart_id' => $model->cart_id, 'trade_proposal_id' => $model->trade_proposal_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cart_id' => $model->cart_id, 'trade_proposal_id' => $model->trade_proposal_id], [
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
            'trade_proposal_id',
            'created_at',
        ],
    ]) ?>

</div>