<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

?>


<div class="user-info-form">

    <?php $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'username')->textInput([
                'readonly' => true,
                'class' => 'form-control readOnly'
            ]) ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'readonly' => true,
                'class' => 'form-control readOnly'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'email')->input('email', [
                'readonly' => true,
                'class' => 'form-control readOnly'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'address')->textInput([
                'readonly' => true,
                'class' => 'form-control readOnly'
            ]) ?>

        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'postal_code')->textInput([
                'readonly' => true,
                'class' => 'form-control readOnly'
            ]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::button('Edit', ['class' => 'btn btn-secondary', 'id' => 'btnEdit']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();
    // Registrar o código JavaScript
    $js = <<<JS
        $('#btnEdit').click(function() {
            $('#w0 input').removeAttr('readonly').removeClass('readOnly');
        });

        // Quando o formulário for submetido, preenchendo o campo oculto com o userId
        $('#user-form').submit(function() {
            var userId = $('#modalUserInfo').data('idUser'); // Recupera o ID do usuário do modal
            $('#userId').val(userId); // Preenche o campo oculto com o userId
        });
        JS;
    $this->registerJs($js);
    ?>

</div>