<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registrar';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="site-register">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    // Exibindo mensagens de erro se houver
    if ($model->hasErrors()) {
        echo '<div class="alert alert-danger">';
        echo implode('<br>', $model->errors['password']);
        echo '</div>';
    }
    ?>