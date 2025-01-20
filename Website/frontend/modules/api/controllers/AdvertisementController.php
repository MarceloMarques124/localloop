<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use common\models\SavedAdvertisement;
use frontend\modules\api\transformers\UserTransformer;
use Yii;
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
        unset($actions['view'], $actions['index']);
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

    public function actionIndex()
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
}
