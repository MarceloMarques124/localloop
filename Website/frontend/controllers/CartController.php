<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Item;
use yii\web\Controller;
use common\models\Trade;
use common\models\CartItem;
use yii\filters\VerbFilter;
use frontend\models\CartSearch;
use common\models\Advertisement;
use common\models\TradeProposal;
use yii\web\NotFoundHttpException;
use common\models\TradeProposalItem;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cart = Cart::find()->where(['state' => 1])->one();
        $userItems = Item::find()->where(['user_info_id' => Yii::$app->user->id])->all();

        if (!$cart) {
            \Yii::$app->session->setFlash('error', 'No open cart found.');
            // Define $advertisements como um array vazio
            $advertisements = [];
        } else {
            $advertisementIds = CartItem::find()
                ->select('advertisement_id') // Campo que guarda o ID do anúncio no modelo SavedAdvertisement
                ->where(['cart_id' => $cart->id])
                ->column();

            $advertisements = Advertisement::find()
                ->where(['id' => $advertisementIds])
                ->all();
        }

        return $this->render('index', [
            'advertisements' => $advertisements,
            'userItems' => $userItems,
        ]);
    }


    /**
     * Displays a single Cart model.
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
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($advertisementId)
    {
        $advertisement = Advertisement::find()->where(['id' => $advertisementId])->one();
        $userItems = Item::find()->where(['user_info_id' => Yii::$app->user->id])->all();
        $userId = Yii::$app->user->id;
        $existingCart = Cart::find()
            ->where(['id' => $userId, 'state' => 1])
            ->one();
        if ($existingCart) {

            $cartItem = new CartItem();
            $cartItem->cart_id = $existingCart->id;
            $cartItem->advertisement_id = $advertisementId;

            if ($cartItem->save()) {
                $advertisementIds = CartItem::find()
                    ->select('advertisement_id') // Campo que guarda o ID do anúncio no modelo SavedAdvertisement
                    ->where(['cart_id' => $existingCart->id])
                    ->column();

                $advertisements = Advertisement::find()
                    ->where(['id' => $advertisementIds])
                    ->all();

                return $this->render('index', [
                    'advertisements' => $advertisements,
                    'userItems' => $userItems,
                ]);
            }
        }

        $model = new Cart();
        $model->id = $userId;
        $model->state = 1;

        if ($model->save()) {
            $cartItem = new CartItem();
            $cartItem->cart_id = $model->id;
            $cartItem->advertisement_id = $advertisementId;

            if ($cartItem->save()) {

                $advertisementIds = CartItem::find()
                    ->select('advertisement_id') // Campo que guarda o ID do anúncio no modelo SavedAdvertisement
                    ->where(['cart_id' => $model->id])
                    ->column();

                $advertisements = Advertisement::find()
                    ->where(['id' => $advertisementIds])
                    ->all();

                return $this->render('index', [
                    'advertisements' => $advertisements,
                    'userItems' => $userItems,
                ]);
            }
        }
    }

    public function actionCheckout()
    {
        $selectedItemId = Yii::$app->request->post('selected_item');
        $userId = Yii::$app->user->id;

        // Obter o carrinho do usuário
        $cart = Cart::find()->where(['id' => $userId, 'state' => 1])->one();

        // Obter os IDs dos anúncios no carrinho
        $advertisementsIds = CartItem::find()
            ->select('advertisement_id')
            ->where(['cart_id' => $cart->id])
            ->column();

        // Iterar sobre os IDs dos anúncios
        foreach ($advertisementsIds as $advertisementId) {
            // Criar uma nova instância de Trade
            $trade = new Trade();
            $trade->advertisement_id = $advertisementId;
            $trade->user_info_id = $userId;
            $trade->state = 1;

            if ($trade->save()) {
                // Criar uma nova instância de TradeProposal
                $tradeProposal = new TradeProposal();
                $tradeProposal->trade_id = $trade->id;
                $tradeProposal->state = 0;
                $tradeProposal->message = 'Want trade my item for yours!';

                if ($tradeProposal->save()) {
                    // Criar uma nova instância de TradeProposalItem
                    $tradeProposalItem = new TradeProposalItem();
                    $tradeProposalItem->trade_proposal_id = $tradeProposal->id;
                    $tradeProposalItem->item_id = $selectedItemId;

                    if ($tradeProposalItem->save()) {
                        // Atualizar o estado do carrinho (apenas quando tudo for bem-sucedido)
                        $cart->save();
                    }
                }
            }
        }

        // Salvar o estado do carrinho
        if ($cart->delete()) {
            Yii::$app->session->setFlash('success', 'Trade proposal sent successfully!');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update cart state.');
            return $this->redirect(['index']);
        }
    }


    /**
     * Updates an existing Cart model.
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
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
