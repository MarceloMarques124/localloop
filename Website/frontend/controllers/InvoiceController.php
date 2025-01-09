<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Invoice;
use yii\filters\VerbFilter;
use common\models\TradeProposal;
use yii\data\ActiveDataProvider;
use frontend\models\InvoiceSearch;
use yii\web\NotFoundHttpException;
use common\models\TradeProposalItem;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->where(['user_info_id' => $id]), // Filtra pelos anúncios do usuário logado
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Carregar a fatura (invoice) pelo id
        $invoice = Invoice::findOne($id);

        if ($invoice === null) {
            throw new NotFoundHttpException("Invoice not found.");
        }

        // Carregar a proposta de trade (TradeProposal) relacionada à invoice
        $tradeProposal = TradeProposal::findOne(['trade_id' => $invoice->trade_id]);

        if ($tradeProposal === null) {
            throw new NotFoundHttpException("TradeProposal not found.");
        }

        // Carregar os itens da proposta de trade (TradeProposalItem) relacionados à invoice
        $tradeProposalItems = TradeProposalItem::find()->where(['trade_proposal_id' => $tradeProposal->id])->all();

        // Carregar as informações do usuário associadas ao trade
        $userInfo = $invoice->trade->userInfo;


        // Passar os dados para a view
        return $this->render('view', [
            'invoice' => $invoice,
            'tradeProposal' => $tradeProposal,
            'tradeProposalItems' => $tradeProposalItems,
            'userInfo' => $userInfo,
        ]);
    }


    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Invoice();

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
     * Updates an existing Invoice model.
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
     * Deletes an existing Invoice model.
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
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
