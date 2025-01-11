<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SavedAdvertisement $model */

$this->title = 'Create Saved Advertisement';
$this->params['breadcrumbs'][] = ['label' => 'Saved Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saved-advertisement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
