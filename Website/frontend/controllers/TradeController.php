<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Trade;
use yii\filters\VerbFilter;
use frontend\models\TradeSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Advertisement;
use common\models\TradeProposal;


/**
 * TradeController implements the CRUD actions for Trade model.
 */
class TradeController extends Controller
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
     * Lists all Trade models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new TradeSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Trade::find()->where(['user_info_id' => $id]),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trade model.
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
     * Creates a new Trade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Trade();

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
     * Updates an existing Trade model.
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
     * Deletes an existing Trade model.
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
     * Finds the Trade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Trade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProposals($userId)
    {
        // 1. Fetch Sent Proposals (Trades initiated by the user)
        $userTrades = Trade::find()->where(['user_info_id' => $userId])->all();
        $userTradeIds = array_column($userTrades, 'id');
        $sentProposals = TradeProposal::find()
            ->where(['trade_id' => $userTradeIds])
            ->with(['trade', 'tradeProposalItems.item'])
            ->all();

        // 2. Fetch Received Proposals (Proposals to user's advertisements)
        $userAds = Advertisement::find()->where(['user_info_id' => $userId])->all();
        $adTradeIds = [];
        foreach ($userAds as $ad) {
            $adTradeIds = array_merge($adTradeIds, array_column($ad->trades, 'id'));
        }
        $receivedProposals = TradeProposal::find()
            ->where(['trade_id' => $adTradeIds])
            ->with(['trade.advertisement', 'tradeProposalItems.item'])
            ->all();

        // 3. Render View
        return $this->render('proposals', [
            'sentProposals' => $sentProposals,
            'receivedProposals' => $receivedProposals,
        ]);
    }
}
