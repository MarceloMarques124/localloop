<?php

namespace frontend\modules\api\controllers;

use common\models\Cart;
use common\models\CartItem;
use Exception;
use Throwable;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class CartController extends ActiveController
{
    public $modelClass = Cart::class;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @throws \yii\db\Exception
     * @throws Throwable
     * @throws NotFoundHttpException
     */
    public function actionToggleItem()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId = Yii::$app->user->id;

        $cart = Cart::findOne($userId);
        if (!$cart) {
            $cart = new Cart(['id' => $userId, 'state' => 1]);
            if (!$cart->save()) {
                return ['status' => 'error', 'errors' => $cart->errors];
            }
        }

        $advertisementId = Yii::$app->request->post();
        if (!$advertisementId) {
            throw new NotFoundHttpException('Advertisement ID is required');
        }

        $cartItem = CartItem::find()
            ->where(['cart_id' => $cart->id, 'advertisement_id' => $advertisementId])
            ->one();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($cartItem) {
                // Remove from cart
                $cartItem->delete();
                $message = 'removed';
            } else {
                // Add to cart
                $newItem = new CartItem([
                    'cart_id' => $cart->id,
                    'advertisement_id' => $advertisementId
                ]);

                if (!$newItem->save()) {
                    throw new Exception('Failed to save cart item');
                }
                $message = 'added';
            }

            $transaction->commit();
            return ['status' => 'success', 'action' => $message];

        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}
