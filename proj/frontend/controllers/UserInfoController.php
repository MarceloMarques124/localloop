<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
use common\models\UserInfo;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\EditUserInfo;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class UserInfoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all UserInfo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserInfo::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserInfo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($model->id);

        return $this->render('view', [
            'model' => $model,
            'user' => $user
        ]);
    }

    /**
     * Creates a new UserInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserInfo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($model->id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $userData = $this->request->post('User');
            $user->username = $userData['username'];
            $user->email = $userData['email'];

            // Verifica se o username ou email existe na db
            $userExists = User::find()
                ->where([
                    'or',
                    ['username' => $user->username],
                    ['email' => $user->email]
                ])
                ->andWhere(['<>', 'id', $user->id])
                ->one(); // Obtém o primeiro registo que corresponda

            if ($userExists) {
                if ($userExists->username === $user->username) {
                    $model->addError('username', 'Este nome de utilizador já está em uso. Por favor, escolha outro.');
                }
                if ($userExists->email === $user->email) {
                    $model->addError('email', 'Este email já está em uso. Por favor, escolha outro.');
                }
            } else {
                if ($user->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionGetUserInfo()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = \Yii::$app->request->get('id');

        if (\Yii::$app->request->isAjax) {
            $user = UserInfo::getUserInfo($id);
            return $user;
        }
    }

    public function actionSaveUserInfo()
    {
        $id = \Yii::$app->request->post('id');
        $userDataString = \Yii::$app->request->post('userData');

        // Converter a string userData em um array
        parse_str($userDataString, $userData);

        if ($id) {
            return EditUserInfo::saveUserInfo($id, $userData);
        }
        throw new BadRequestHttpException('ID não fornecido');
    }



    /**
     * Deletes an existing UserInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserInfo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
