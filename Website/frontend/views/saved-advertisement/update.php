<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SavedAdvertisement $model */

$this->title = 'Update Saved Advertisement: ' . $model->user_info_id;
$this->params['breadcrumbs'][] = ['label' => 'Saved Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_info_id, 'url' => ['view', 'user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saved-advertisement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
