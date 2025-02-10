<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use common\models\CartItem;
use common\models\SavedAdvertisement;
use common\models\Trade;
use frontend\modules\api\transformers\UserTransformer;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;


class AdvertisementController extends ActiveController
{
    public $modelClass = Advertisement::class;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['index'], $actions['create']);
        return $actions;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $advertisement = Advertisement::find()
            ->with(['userInfo', 'userInfo.user'])
            ->where(['id' => $id])
            ->asArray()
            ->one();

        if (!$advertisement) {
            throw new NotFoundHttpException('Advertisement not found.');
        }

        $currentUserId = Yii::$app->user->id;

        $userTrade = Trade::find()
            ->where(['advertisement_id' => $id, 'user_info_id' => $currentUserId])
            ->asArray()
            ->one();

        try {
            $cartItem = CartItem::find()
                ->where(['advertisement_id' => $id, 'cart_id' => $currentUserId])
                ->asArray()
                ->one();

            $advertisement['is_on_cart'] = $cartItem !== null ? 1 : 0;
        } catch (\Exception $e) {
            Yii::error('Failed to fetch cart item: ' . $e->getMessage());
            $advertisement['is_on_cart'] = 0;
        }

        $advertisement['current_user_trade'] = $userTrade;
        $advertisement['user'] = UserTransformer::transform($advertisement['userInfo']);
        unset($advertisement['userInfo']);

        return $advertisement;
    }

    public function actionIndex(): array
    {
        $userId = Yii::$app->user->id;

        $advertisements = Advertisement::find()
            ->with(['userInfo', 'userInfo.user'])
            ->asArray()
            ->all();

        foreach ($advertisements as &$advertisement) {
            $isSaved = SavedAdvertisement::find()
                ->where(['advertisement_id' => $advertisement['id'], 'user_info_id' => $userId])
                ->exists();
            $advertisement['is_saved'] = $isSaved ? 1 : 0;

            unset($advertisement['userInfo']);
        }

        return $advertisements;
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): Advertisement
    {
        $userId = Yii::$app->user->id;

        $request = Yii::$app->request->post();

        $advertisement = new Advertisement();
        $advertisement->user_info_id = $userId;
        $advertisement->title = $request['title'] ?? null;
        $advertisement->description = $request['description'] ?? null;
        $advertisement->is_service = $request['is_service'] ?? 0;

        if (!$advertisement->save()) {
            throw new StaleObjectException('Failed to save Advertisement: ' . json_encode($advertisement->errors));
        }
        return $advertisement;
    }
}
