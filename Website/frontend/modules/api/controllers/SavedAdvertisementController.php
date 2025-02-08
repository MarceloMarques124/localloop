<?php

namespace frontend\modules\api\controllers;

use common\models\SavedAdvertisement;
use Yii;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;

class SavedAdvertisementController extends ActiveController
{
    public $modelClass = SavedAdvertisement::class;

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
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {

        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }


        $request = Yii::$app->request;
        $advertisementId = $request->post();

        $savedAdvertisement = new SavedAdvertisement();
        $savedAdvertisement->advertisement_id = $advertisementId;
        $savedAdvertisement->user_info_id = $user->id;

        if (!$savedAdvertisement->save()) {
            throw new StaleObjectException('Failed to save Advertisement: ' . json_encode($savedAdvertisement->errors));
        }
        return $savedAdvertisement;
    }
}
