<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\TradeProposal $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Proposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="trade-proposal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'state',
            'message',
            'created_at',
        ],
    ]) ?>

</div>