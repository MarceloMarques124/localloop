<?php

namespace backend\controllers;

use common\models\Advertisement;
use common\models\LoginForm;
use common\models\Report;
use common\models\Trade;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $totalReports = Report::getTotalReports();
        $totalUsers = User::getTotalUsers();
        $totalAdvertisements = Advertisement::getTotalAdvertisements();
        $totalTrades = Trade::getTotalTrades();


        return $this->render('index', [
            'totalReports' => $totalReports,
            'totalUsers' => $totalUsers,
            'totalAdvertisements' => $totalAdvertisements,
            'totalTrades' => $totalTrades,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;


            // Verifica se o usuário tem a permissão de loginReviewer
            if (!Yii::$app->user->can('reviwer')) {
                Yii::$app->session->setFlash('error', 'Apenas revisores podem fazer login.');
                Yii::$app->user->logout();
                return $this->goBack();
            }

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
