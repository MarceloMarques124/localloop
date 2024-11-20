<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UserInfo $model */
/** @var common\models\User $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
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
        ],
    ]) ?>
</div>