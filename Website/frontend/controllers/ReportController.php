<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Report;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\ReportSearch;
use yii\web\NotFoundHttpException;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller
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
     * Lists all Report models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new ReportSearch();
        // Filtra os relatórios pelo ID no modelo Report
        $query = Report::find()->where(['author_id' => $id]); // Troque 'user_info_id' pelo nome do campo correto

        // Cria o DataProvider com a query filtrada
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
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

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($entityType, $entityId)
    {
        $model = new Report();

        $model->author_id = Yii::$app->user->id;

        switch ($entityType) {
            case 'advertisement':
                $model->advertisement_id = $entityId;
                break;
            case 'user':
                $model->user_info_id = $entityId;
                break;
            case 'trade':
                $model->trade_id = $entityId;
                break;
            default:
                throw new \yii\web\BadRequestHttpException('Invalid report entity type.');
        }

        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // If saving fails, render the 'create' view with errors
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Report model.
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
     * Deletes an existing Report model.
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
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
