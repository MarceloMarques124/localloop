<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use frontend\modules\api\transformers\UserTransformer;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;


class AdvertisementController extends ActiveController
{
    public $modelClass = Advertisement::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        return $actions;
    }

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

        $advertisement['user'] = UserTransformer::transform($advertisement['userInfo']);
        unset($advertisement['userInfo']);

        return $advertisement;
    }
}
