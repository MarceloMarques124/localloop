<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SavedAdvertisement $model */

$this->title = $model->user_info_id;
$this->params['breadcrumbs'][] = ['label' => 'Saved Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="saved-advertisement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_info_id',
            'advertisement_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
