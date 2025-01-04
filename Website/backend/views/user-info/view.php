<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UserInfo $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('admin')) {
        ?>

            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(
                $user->status == 10 ? 'Deactivate' : 'Activate',
                ['user-info/toggle-status', 'id' => $user->id],
                [
                    'class' => 'btn btn-' . ($user->status == 10 ? 'danger' : 'success'),
                    'data' => [
                        'confirm' => 'Are you sure you want to ' . ($user->status == 10 ? 'deactivate' : 'activate') . ' this user?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php } ?>

        <?= Html::a(
            $model->flagged_for_ban == 1 ? 'Unban' : 'Ban',
            ['user-info/toggle-ban-status', 'id' => $model->id],
            [
                'class' => 'btn btn-' . ($model->flagged_for_ban == 1 ? 'success' : 'danger'),
                'data' => [
                    'confirm' => 'Are you sure you want to ' . ($model->flagged_for_ban == 1 ? 'unban' : 'ban') . ' this user?',
                    'method' => 'post',
                ],
            ]
        ) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // Atributos do modelo User
            [
                'label' => 'Username',
                'value' => $user->username, // Acessando o atributo username do User
            ],
            [
                'label' => 'Email',
                'value' => $user->email, // Acessando o atributo email do User
            ],
            'address',
            'postal_code',
            [
                'attribute' => 'flagged_for_ban',
                'value' => function ($model) {
                    return $model->flagged_for_ban == 1 ? 'Yes' : 'No'; // Retorna "Yes" ou "No"
                },
            ],
        ],
    ]) ?>

</div>