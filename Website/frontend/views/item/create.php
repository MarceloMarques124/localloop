<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Item $model */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'subCategories' => $subCategories,
    ]) ?>

</div>