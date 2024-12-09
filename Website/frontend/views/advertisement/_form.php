<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Advertisement $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advertisement-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'title')->textInput([
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="col-12 col-md-6">
            <?= $form->field($model, 'is_service')->dropDownList(
                [ // Valores do dropdown
                    1 => 'Service',
                    0 => 'Item'
                ],
                ['prompt' => 'Select a option'] // Placeholder inicial
            ) ?>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <?= $form->field($model, 'description')->textArea([
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>