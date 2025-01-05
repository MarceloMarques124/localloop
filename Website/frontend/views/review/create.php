<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Leave a Review for Trade #<?= Html::encode($trade->id) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'message')->textarea(['rows' => 4]) ?>
<?= $form->field($model, 'stars')->dropDownList([1, 2, 3, 4, 5]) ?>

<div class="form-group">
    <?= Html::submitButton('Submit Review', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>