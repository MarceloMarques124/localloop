<?php
$this->params['breadcrumbs'][] = $this->title;
?>
<a href="<?= \yii\helpers\Url::to(['trade-proposal/create', 'advertisementId' => $model->id]) ?>" class="btn btn-primary">Trade</a>