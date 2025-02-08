<?php

use frontend\modules\api\controllers\CurrentUserController;
use frontend\modules\api\ModuleApi;
use yii\log\FileTarget;
use yii\rest\UrlRule;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => ModuleApi::class,
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => UrlRule::class, 'controller' => 'api/auth', 'extraPatterns' => [
                    'POST login' => 'login',
                    'POST signup' => 'signup',
                ]],
                ['class' => UrlRule::class, 'controller' => 'api/advertisement', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/cart', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/cart-item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/invoice', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/report', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/saved-advertisement', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/trade', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/trade-proposal', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/trade-proposal-item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/review', 'tokens' => ['{id}' => '<id:\d+>']],
                ['class' => UrlRule::class, 'controller' => 'api/user', 'extraPatterns' => [
                    'GET current-user' => 'get-current-user',
                ]],
                [
                    'class' => UrlRule::class,
                    'controller' => CurrentUserController::class,
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET' => 'index',
                        'GET items' => 'items',
                        'GET profile' => 'profile',
                        'GET sent-trades' => 'sent-trades',
                        'GET received-trades' => 'received-trades',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
