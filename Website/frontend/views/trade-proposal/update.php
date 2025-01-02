<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TradeProposal $model */

$this->title = 'Update Trade Proposal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Proposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trade-proposal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userItem' => $userItems,
    ]) ?>

</div>