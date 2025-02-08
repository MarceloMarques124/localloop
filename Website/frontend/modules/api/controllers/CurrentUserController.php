<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use common\models\Item;
use common\models\Trade;
use common\models\UserInfo;
use frontend\modules\api\transformers\UserTransformer;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


class CurrentUserController extends ActiveController
{
    public $modelClass = UserInfo::class;

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
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionIndex(): array
    {
        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        $userInfo = UserInfo::find()->where(['id' => $user->id])->one();

        if (!$userInfo) {
            throw new BadRequestHttpException('User info not found.');
        }

        return UserTransformer::transform($userInfo);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionItems(): array
    {
        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        return Item::find()->where(['user_info_id' => $user->id])->asArray()->all();
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionProfile(): array
    {
        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        $userInfo = UserInfo::findOne($user->id);

        if (!$userInfo) {
            throw new BadRequestHttpException('User info not found.');
        }

        $userData = UserTransformer::transform($userInfo);
        $userData['items'] = Item::find()->where(['user_info_id' => $user->id])->asArray()->all();
        $userData['advertisements'] = Advertisement::find()->where(['user_info_id' => $user->id])->asArray()->all();

        return $userData;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionTradePartners(): array
    {
        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        $userInfoId = $user->id;

        $trades = Trade::find()
            ->where(['user_info_id' => $userInfoId])
            ->orWhere(['advertisement_id' => Advertisement::find()->select('id')->where(['user_info_id' => $userInfoId])])
            ->all();

        $userIds = array_unique(array_map(function ($trade) use ($userInfoId) {
            return $trade->user_info_id !== $userInfoId ? $trade->user_info_id : $trade->advertisement->user_info_id;
        }, $trades));

        $tradePartners = UserInfo::find()->where(['id' => $userIds])->all();

        return array_map(fn($partner) => UserTransformer::transform($partner), $tradePartners);
    }

}
