<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;
use common\models\Trade;
use commo\models\UserInfo;
use common\models\Invoice;
use yii\filters\VerbFilter;
use common\models\TradeProposal;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\TradeProposalItem;
use yii\web\BadRequestHttpException;
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
            Yii::$app->session->setFlash('error', 'Dont have item to trade. Create your own item.');
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
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($trade->save()) {
                    $model->trade_id = $trade->id;
                    /* trade proposal states~
                    2 - rejected
                    1 - acepted trade
                    0 - open trade */
                    $model->state = 0;
                    if ($model->save()) {
                        $tradeProposalItem = new TradeProposalItem;
                        $tradeProposalItem->trade_proposal_id = $model->id;
                        $tradeProposalItem->item_id = $model->item_id;
                        if ($tradeProposalItem->save()) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
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

    public function actionUpdateState($id, $state)
    {
        $model = TradeProposal::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Trade proposal not found.');
        }

        // Ensure the logged-in user is authorized
        if ($model->trade->advertisement->user_info_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not authorized to update this proposal.');
        }
        // Update the state
        if (in_array($state, [1, 2])) { // 1 = Accept, 2 = Reject
            $model->state = $state;
            if ($model->save()) {
                $trade = Trade::find()->where(['id' => $model->trade->id])->one();
                $trade->state = 0;
                $trade->save();

                $invoice = new Invoice();
                $invoice->trade_id = $trade->id;
                $invoice->user_info_id = $trade->user_info_id;

                $invoice->save();

                Yii::$app->session->setFlash('success', $state == 1 ? 'Proposal accepted!' : 'Proposal rejected!');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update the proposal.');
            }
        } else {
            throw new BadRequestHttpException('Invalid state.');
        }

        return $this->redirect(['trade/received-index', 'id' => Yii::$app->user->id]); // Redirect back to trade details
    }
}
