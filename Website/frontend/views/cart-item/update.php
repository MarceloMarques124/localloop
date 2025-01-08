<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CartItem $model */

$this->title = 'Update Cart Item: ' . $model->cart_id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cart_id, 'url' => ['view', 'cart_id' => $model->cart_id, 'trade_proposal_id' => $model->trade_proposal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cart-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
