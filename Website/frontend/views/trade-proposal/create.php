<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TradeProposal $model */

$this->title = 'Create Trade Proposal';
$this->params['breadcrumbs'][] = ['label' => 'Trade Proposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-proposal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
