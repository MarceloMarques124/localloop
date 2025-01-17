<?php

namespace frontend\modules\api\controllers;

use common\models\UserInfo;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;


class UserController extends ActiveController
{
    public $modelClass = UserInfo::class;

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

        $flattenedData = array_map(function ($model) {
            $user = $model['user'];

            $model['username'] = $user['username'];
            $model['email'] = $user['email'];
            $model['status'] = $user['status'];

            unset($model['user']);

            return $model;
        }, $models);

        return $flattenedData;
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

        $flattenedData = array_map(function ($model) {
            $user = $model['user'];

            $model['username'] = $user['username'];
            $model['email'] = $user['email'];
            $model['status'] = $user['status'];

            unset($model['user']);

            return $model;
        }, $models);

        return $flattenedData;
    }

}
