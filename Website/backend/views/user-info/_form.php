<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="user-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'username')->textInput([
                'readonly' => Yii::$app->controller->action->id == 'update', // Só readonly se for update
                'class' => 'form-control ' . (Yii::$app->controller->action->id == 'update' ? 'readOnly' : '')
            ]) ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'readonly' => Yii::$app->controller->action->id == 'update', // Só readonly se for update
                'class' => 'form-control ' . (Yii::$app->controller->action->id == 'update' ? 'readOnly' : '')
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'email')->input('email', [
                'readonly' => Yii::$app->controller->action->id == 'update', // Só readonly se for update
                'class' => 'form-control ' . (Yii::$app->controller->action->id == 'update' ? 'readOnly' : '')
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'address')->textInput([
                'readonly' => Yii::$app->controller->action->id == 'update', // Só readonly se for update
                'class' => 'form-control ' . (Yii::$app->controller->action->id == 'update' ? 'readOnly' : '')
            ]) ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'postal_code')->textInput([
                'readonly' => Yii::$app->controller->action->id == 'update', // Só readonly se for update
                'class' => 'form-control ' . (Yii::$app->controller->action->id == 'update' ? 'readOnly' : '')
            ]) ?>
        </div>
    </div>

    <?php if (Yii::$app->controller->action->id == 'create'): ?>
        <div class="row">
            <div class="col-12 col-md-3">
                <?= $form->field($model, 'role')->dropDownList(
                    ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'), // Lista de roles
                    ['prompt' => 'Selecione a Role', 'class' => 'form-control']
                ) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id == 'update') { ?>
            <?= Html::button('Edit', ['class' => 'btn btn-secondary', 'id' => 'btnEdit']) ?>
        <?php } ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    // Registrar o código JavaScript
    $js = <<<JS
        $('#btnEdit').click(function() {
            $('#w0 input').removeAttr('readonly').removeClass('readOnly');
        });

        showToast();

        // Quando o formulário for submetido, preenchendo o campo oculto com o userId
        $('#user-form').submit(function() {
            var userId = $('#modalUserInfo').data('idUser'); // Recupera o ID do usuário do modal
            $('#userId').val(userId); // Preenche o campo oculto com o userId
        });
    JS;
    $this->registerJs($js);
    ?>

</div>