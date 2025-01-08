<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-page container-fluid">
    <div class="container my-4 p-4 bg-white shadow rounded">
        <!-- Título principal -->
        <div class="text-center mb-4 border-bottom pb-2">
            <h1 class="h3"><?= Html::encode($this->title) ?></h1>
        </div>
        <!-- Seções de Informação -->
        <div class="row g-4"
            <!-- Informação do Anúncio -->
            <div class="col-md-12">
                <?php foreach ($advertisements as $advertisement): ?>
                    <div class="p-3 bg-light rounded shadow-sm">

                        <h2 class="h5">Advertisement details</h2>

                        <p><span class="fw-bold">Title:</span> <?= Html::encode($advertisement->title) ?></p>
                        <p><span class="fw-bold">Description:</span> <?= Html::encode($advertisement->description) ?></p>
                        <p><span class="fw-bold">Service/Item:</span> <?= $advertisement->is_service == 1 ? 'Service' : 'Item' ?></p>


                    </div>
                <?php endforeach; ?>

                <?php if ($advertisements): ?>
                    <!-- Dropdown e Botão Finalizar -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin([
                                'action' => Url::to(['cart/checkout']), // Ajuste a rota conforme necessário
                                'method' => 'post',
                            ]); ?>

                            <div class="form-group">
                                <label for="selected-item" class="fw-bold">Select an item:</label>
                                <select name="selected_item" id="selected-item" class="form-control">
                                    <!-- Opção inicial padrão -->
                                    <option value="" disabled selected>Select one item!</option>
                                    <?php foreach ($userItems as $item): ?>
                                        <option value="<?= $item->id ?>"><?= Html::encode($item->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Finalize Cart</button>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>