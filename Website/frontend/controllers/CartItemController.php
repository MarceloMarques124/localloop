<?php

namespace frontend\controllers;

use common\models\CartItem;
use frontend\models\CartItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartItemController implements the CRUD actions for CartItem model.
 */
class CartItemController extends Controller
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
     * Lists all CartItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CartItem model.
     * @param int $cart_id Cart ID
     * @param int $trade_proposal_id Trade Proposal ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cart_id, $trade_proposal_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cart_id, $trade_proposal_id),
        ]);
    }

    /**
     * Creates a new CartItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CartItem();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cart_id' => $model->cart_id, 'trade_proposal_id' => $model->trade_proposal_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CartItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cart_id Cart ID
     * @param int $trade_proposal_id Trade Proposal ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cart_id, $trade_proposal_id)
    {
        $model = $this->findModel($cart_id, $trade_proposal_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cart_id' => $model->cart_id, 'trade_proposal_id' => $model->trade_proposal_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CartItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cart_id Cart ID
     * @param int $trade_proposal_id Trade Proposal ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cart_id, $trade_proposal_id)
    {
        $this->findModel($cart_id, $trade_proposal_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CartItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cart_id Cart ID
     * @param int $trade_proposal_id Trade Proposal ID
     * @return CartItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cart_id, $trade_proposal_id)
    {
        if (($model = CartItem::findOne(['cart_id' => $cart_id, 'trade_proposal_id' => $trade_proposal_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
