<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Item $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($subCategories, 'id', 'name'), // Mapeia os dados das categorias
        ['prompt' => 'Select a Category'] // Adiciona uma opção padrão
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>