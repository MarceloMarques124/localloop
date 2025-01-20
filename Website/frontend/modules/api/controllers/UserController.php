<?php

namespace frontend\modules\api\controllers;

use common\models\UserInfo;
use frontend\modules\api\transformers\UserTransformer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


class UserController extends ActiveController
{
    public $modelClass = UserInfo::class;

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
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = UserInfo::find()->with(['user'])->asArray();

        $query->select([
            'id', 'name', 'address', 'postal_code', 'flagged_for_ban', 'created_at', 'updated_at',
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $models = $dataProvider->getModels();

        return array_map(fn($model) => UserTransformer::transform($model), $models);
    }

    public function actionView($id)
    {
        $query = UserInfo::find()->where(['id' => $id])->with(['user'])->asArray();

        $query->select([
            'id', 'name', 'address', 'postal_code', 'flagged_for_ban', 'created_at', 'updated_at',
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $models = $dataProvider->getModels();

        return array_map(fn($model) => UserTransformer::transform($model), $models);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionGetCurrentUser()
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
}
