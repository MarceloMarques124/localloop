<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;
use common\models\UserInfo;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Advertisement;
use yii\data\ActiveDataProvider;
use frontend\models\Advertisiment;
use yii\web\NotFoundHttpException;
use common\models\SavedAdvertisement;

/**
 * AdvertisementController implements the CRUD actions for Advertisement model.
 */
class AdvertisementController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                        [
                            'actions' => ['page'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['myOwnAdvertisement'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Advertisement models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new Advertisiment();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        //$userId = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Advertisement::find()->where(['user_info_id' => $id]), // Filtra pelos anúncios do usuário logado
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisement model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPage($id)
    {
        $advertisement = Advertisement::find()->where(['id' => $id])->one();
        $savedAdvertisement = SavedAdvertisement::find()->where(['advertisement_id' => $advertisement->id])->one();
        $userInfo = UserInfo::find()->where(['id' => $advertisement->userInfo->id])->one();
        return $this->render('page', [
            'advertisement' => $advertisement,
            'userInfo' => $userInfo,
            'savedAdvertisement' => $savedAdvertisement
        ]);
    }

    /**
     * Creates a new Advertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Advertisement();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_info_id = $id;
                $model->created_at = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Advertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Advertisement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Advertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Advertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertisement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
