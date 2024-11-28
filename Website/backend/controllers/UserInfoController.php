<?php

namespace backend\controllers;

use common\models\User;
use yii\web\Controller;
use common\models\UserInfo;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\EditUserInfo;
use yii\web\NotFoundHttpException;

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
            'query' => UserInfo::find()->with('user'),
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
        $model = new EditUserInfo();
        //$model->scenario = 'create'; // Define o cenário para validação

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validate()) {
                // Inicializa os modelos reais
                $user = new User();
                $userInfo = new UserInfo();

                // Atualiza os modelos reais com os dados validados
                $user->username = $model->username;
                $user->email = $model->email;

                if ($user->save()) {
                    // Associa o UserInfo ao User salvo
                    $userInfo->id = $user->id; // Certifique-se de que o campo `user_id` existe
                    $userInfo->name = $model->name;
                    $userInfo->address = $model->address;
                    $userInfo->postal_code = $model->postal_code;

                    if ($userInfo->save()) {
                        \Yii::$app->session->setFlash('success', 'Informações atualizadas com sucesso!');
                        return $this->render('view', [
                            'model' => $userInfo,
                            'user' => $user,
                        ]);
                    } else {
                        // Exibe os erros do UserInfo caso o salvamento falhe
                        \Yii::$app->session->setFlash('error', implode('<br>', array_map(fn($e) => implode(', ', $e), $userInfo->getErrors())));
                    }
                } else {
                    // Exibe os erros do User caso o salvamento falhe
                    \Yii::$app->session->setFlash('error', implode('<br>', array_map(fn($e) => implode(', ', $e), $user->getErrors())));
                }
            } else {
                // Exibe erros de validação
                \Yii::$app->session->setFlash('error', implode('<br>', array_map(fn($e) => implode(', ', $e), $model->getErrors())));
            }
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
        // Carrega os modelos reais da base de dados
        $user = User::findOne($id);
        $userInfo = UserInfo::findOne($id);

        if (!$user || !$userInfo) {
            throw new \yii\web\NotFoundHttpException('User not found.');
        }

        // Cria uma instância do modelo `EditUserInfo`
        $model = new EditUserInfo();
        // $model->scenario = 'update'; // Define o cenário para validação

        // Carrega os dados atuais nos modelos
        $model->username = $user->username;
        $model->email = $user->email;
        $model->name = $userInfo->name;
        $model->address = $userInfo->address;
        $model->postal_code = $userInfo->postal_code;
        $model->id = $id; // Atribui o ID ao modelo de validação

        // Verifica se os dados foram enviados via POST
        if ($this->request->isPost) {
            // Carrega os dados vindos do POST nas chaves certas
            if ($model->load($this->request->post())) {
                // dd($model);

                // Valida os dados carregados
                if ($model->validate()) {

                    // Atualiza os modelos reais com os dados validados do `EditUserInfo`
                    $user->username = $model->username;
                    $user->email = $model->email;
                    $userInfo->name = $model->name;
                    $userInfo->address = $model->address;
                    $userInfo->postal_code = $model->postal_code;

                    // Salva os dados nos modelos reais
                    if ($user->save() && $userInfo->save()) {
                        \Yii::$app->session->setFlash('success', 'Informações atualizadas com sucesso!');
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    } else {
                        // Exibe erros de salvamento
                        $errors = array_merge($user->getErrors(), $userInfo->getErrors());
                        $errorMessages = [];

                        foreach ($errors as $attribute => $error) {
                            $errorMessages[] = implode(', ', $error);
                        }

                        \Yii::$app->session->setFlash('error', implode('<br>', $errorMessages));
                    }
                } else {
                    // Exibe erros de validação
                    $validationErrors = $model->getErrors();
                    $validationMessages = [];

                    foreach ($validationErrors as $attribute => $errors) {
                        $validationMessages[] = implode(', ', $errors);
                    }

                    \Yii::$app->session->setFlash('error', implode('<br>', $validationMessages));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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

    public function actionToggleStatus($id)
    {
        $user = $user = User::findOne($id);
        $user->status = $user->status == 10 ? 9 : 10;
        $user->save();

        \Yii::$app->session->setFlash('success', 'User status updated successfully.');
        return $this->redirect(['index']);
    }
    public function actionToggleBanStatus($id)
    {
        $model = $this->findModel($id);
        $model->flagged_for_ban = $model->flagged_for_ban == 1 ? 0 : 1;
        $model->save();

        \Yii::$app->session->setFlash('success', 'User status updated successfully.');
        return $this->redirect(['index']);
    }
}
