<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;


class AdvertisementController extends ActiveController
{
    public $modelClass = Advertisement::class;

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

        $userInfo = $advertisement['userInfo'];
        $user = $userInfo['user'];

        $advertisement['user'] = [
            'id' => $userInfo['id'],
            'name' => $userInfo['name'],
            'address' => $userInfo['address'],
            'postal_code' => $userInfo['postal_code'],
            'flagged_for_ban' => $userInfo['flagged_for_ban'],
            'created_at' => $userInfo['created_at'],
            'updated_at' => $userInfo['updated_at'],
            'username' => $user['username'],
            'email' => $user['email'],
            'status' => $user['status'],
        ];

        unset($advertisement['userInfo']);
        unset($advertisement['userInfo']['user']);

        return $advertisement;
    }
}
