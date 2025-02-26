<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TradeProposal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="trade-proposal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'item_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($userItems, 'id', 'name'),
        ['prompt' => 'Select a Item']
    )->label('Item name') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>