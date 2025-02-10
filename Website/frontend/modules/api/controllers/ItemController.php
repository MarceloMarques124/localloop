<?php

namespace frontend\modules\api\controllers;

use common\models\Item;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


class ItemController extends ActiveController
{
    public $modelClass = Item::class;


    public function actionIndex($userId): array
    {
        $user = Yii::$app->user->identity;

        if ($user === null || $userId == null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        return Item::find()->where(['user_info_id' => $userId])->asArray()->all();
    }
}
