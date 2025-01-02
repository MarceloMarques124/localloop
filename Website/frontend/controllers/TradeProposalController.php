<?php

namespace frontend\controllers;

use commo\models\UserInfo;
use Yii;
use common\models\Item;
use yii\web\Controller;
use common\models\Trade;
use yii\filters\VerbFilter;
use common\models\TradeProposal;
use yii\web\NotFoundHttpException;
use common\models\TradeProposalItem;
use frontend\models\TradeProposalSearch;

/**
 * TradeProposalController implements the CRUD actions for TradeProposal model.
 */
class TradeProposalController extends Controller
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
     * Lists all TradeProposal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TradeProposalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TradeProposal model.
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
     * Creates a new TradeProposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($advertisementId)
    {
        $userId = Yii::$app->user->id;
        $userItems = Item::find()->where(['user_info_id' => $userId])->all();
        // Verificar se há itens do usuário
        if (empty($userItems)) {
            Yii::$app->session->setFlash('error', 'Você não possui itens disponíveis para troca.');
            return $this->redirect(['advertisement/page', 'id' => $advertisementId]);
        }
        $model = new TradeProposal();
        $trade = new Trade();

        $trade->advertisement_id = $advertisementId;
        $trade->user_info_id = $userId;

        /* trade states
        1 - active trade
        0 - closed trade */
        $trade->state = 1;

        if ($trade->save()) {
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->trade_id = $trade->id;
                    $model->state = 1; //state 1 -> sent trade
                    if ($model->save()) {
                        $tradeProposalItem = new TradeProposalItem;
                        $tradeProposalItem->trade_proposal_id = $model->id;
                        $tradeProposalItem->item_id = $model->item_id;
                        if ($tradeProposalItem->save()) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'userItems' => $userItems,
            ]);
        }
    }

    /**
     * Updates an existing TradeProposal model.
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
     * Deletes an existing TradeProposal model.
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
     * Finds the TradeProposal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TradeProposal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TradeProposal::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
