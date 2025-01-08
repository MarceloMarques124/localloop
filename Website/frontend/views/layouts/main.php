<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use common\widgets\Alert;
use yii\bootstrap5\NavBar;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>


<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>

        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);

        // // Parte da esquerda (nome da aplicação)
        // echo Html::tag('div', Yii::$app->name, [
        //     'class' => 'navbar-brand d-flex justify-content-start me-auto',  // 'me-auto' empurra os itens seguintes para a direita
        // ]);

        // Parte da direita (ícones)
        if (Yii::$app->user->can('user')) {
            $user = Yii::$app->user;

            $menuItems = [
                [
                    'label' => '<i class="fas fa-user"></i>',
                    'encode' => false,
                    'items' => [ // Adicionando um dropdown
                        [
                            'label' => 'User Info',
                            'encode' => false,
                            'url' => ['user-info/update', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Advertisements',
                            'encode' => false,
                            'url' => ['advertisement/index', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Items',
                            'encode' => false,
                            'url' => ['item/index', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Reports',
                            'encode' => false,
                            'url' => ['report/index', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Logout',
                            'encode' => false,
                            'url' => ['site/logout'], // Defina a URL de logout conforme necessário
                            'linkOptions' => [
                                'data-method' => 'post', // Para enviar o logout como um post
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                    ],
                ],
                [
                    'label' => '<i class="fas fa-heart"></i>',
                    'encode' => false,
                    'url' => ['saved-advertisement/index', 'id' => $user->id],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'style' => 'cursor: pointer;',
                    ],
                ],
                [
                    'label' => '<i class="fas fa-bell"></i>',
                    'encode' => false,
                    'linkOptions' => [
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '',
                        'data-user-id' => $user->id,
                        'style' => 'cursor: pointer;',
                    ],
                    'url' => '#',
                ],
                [
                    'label' => '<i class="fas fa-briefcase"></i>',
                    'encode' => false,
                    'items' => [
                        [
                            'label' => 'Trades done',
                            'encode' => false,
                            'url' => ['trade/index', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Trades Received',
                            'encode' => false,
                            'url' => ['trade/received-index', 'id' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],
                        [
                            'label' => 'Proposals',
                            'encode' => false,
                            'url' => ['trade/proposals', 'userId' => $user->id],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'cursor: pointer;',
                            ],
                        ],

                    ]
                ],
                [
                    'label' => '<i class="fas fa-shopping-cart"></i>',
                    'encode' => false,
                    'url' => ['cart/index', 'id' => $user->id],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'style' => 'cursor: pointer;',
                    ],
                ],
                [
                    'label' => '<i class="fas fa-plus-circle"></i> Criar Anúncio',
                    'encode' => false,
                    'url' => ['advertisement/create', 'id' => $user->id],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'style' => 'cursor: pointer;',
                    ],
                ],
            ];

            // Exibe os ícones na navbar à direita
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],  // 'ms-auto' para alinhar à direita
                'items' => $menuItems,
            ]);
        }

        if (Yii::$app->user->isGuest) {
            echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
            echo Html::tag('div', Html::a('Signup', ['/site/signup'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
        }

        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>


    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage();
