<?php

use common\models\UserInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('admin')) { ?>
            <?= Html::a('Create User Info', ['create'], ['class' => 'btn btn-success']) ?>
        <?php }  ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'address',
            'postal_code',
            [
                'attribute' => 'flagged_for_ban', // Nome do atributo no modelo
                'value' => function ($model) {
                    return $model->flagged_for_ban == 1 ? 'Yes' : 'No'; // Retorna "Yes" ou "No"
                },
            ],
            // Access User model properties directly
            'user.username',
            'user.email',
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'text-align:center;'],
                'template' => '{view} {update} {activate} {deactivate} {ban} {unban}', // Inclui todos os botões no template
                'urlCreator' => function ($action, UserInfo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    // Botão "Ativar" (aparece somente se o usuário estiver desativado)
                    // 'activate' => function ($url, $model, $key) {
                    //     if ($model->status === 'inactive') { // Verifica o estado do usuário
                    //         return Html::a(
                    //             '<i class="fas fa-toggle-on text-success"></i>', // Ícone de ativar
                    //             ['toggle-status', 'id' => $model->id],
                    //             [
                    //                 'title' => 'Ativar',
                    //                 'aria-label' => 'Ativar',
                    //                 'data-pjax' => '0',
                    //             ]
                    //         );
                    //     }
                    //     return ''; // Não exibe o botão se o estado não for "inactive"
                    // },
                    // // Botão "Desativar" (aparece somente se o usuário estiver ativo)
                    // 'deactivate' => function ($url, $model, $key) {
                    //     if ($model->status === 'active') { // Verifica o estado do usuário
                    //         return Html::a(
                    //             '<i class="fas fa-toggle-off text-danger"></i>', // Ícone de desativar
                    //             ['toggle-status', 'id' => $model->id],
                    //             [
                    //                 'title' => 'Desativar',
                    //                 'aria-label' => 'Desativar',
                    //                 'data-pjax' => '0',
                    //             ]
                    //         );
                    //     }
                    //     return ''; // Não exibe o botão se o estado não for "active"
                    // },
                    // Botão "Banir" (aparece somente se o usuário NÃO estiver banido)
                    'ban' => function ($url, $model, $key) {
                        if ($model->flagged_for_ban == 0) { // Verifica se o usuário não está banido
                            return Html::a(
                                '<i class="fas fa-ban text-danger"></i>', // Ícone de banir
                                ['toggle-ban-status', 'id' => $model->id],
                                [
                                    'title' => 'Banir Usuário',
                                    'aria-label' => 'Banir Usuário',
                                    'data-pjax' => '0',
                                ]
                            );
                        }
                        return ''; // Não exibe o botão se o estado for "banned"
                    },
                    // Botão "Remover Ban" (aparece somente se o usuário estiver banido)
                    'unban' => function ($url, $model, $key) {
                        if ($model->flagged_for_ban == 1) { // Verifica se o usuário está banido
                            return Html::a(
                                '<i class="fas fa-user-check text-success"></i>', // Ícone de remover ban
                                ['toggle-ban-status', 'id' => $model->id],
                                [
                                    'title' => 'Remover Banimento',
                                    'aria-label' => 'Remover Banimento',
                                    'data-pjax' => '0',
                                ]
                            );
                        }
                        return ''; // Não exibe o botão se o estado não for "banned"
                    },
                ],
            ],


        ],
    ]); ?>


</div>