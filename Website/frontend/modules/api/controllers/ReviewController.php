<?php

namespace frontend\modules\api\controllers;

use common\models\Review;
use Yii;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ReviewController extends ActiveController
{
    public $modelClass = Review::class;

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
        unset($actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        if ($user === null) {
            throw new BadRequestHttpException('User not authenticated.');
        }

        $request = Yii::$app->request->post();
        $review = new Review();
        $review->load($request, '');

        if (!$review->save()) {
            throw new StaleObjectException('Failed to save review: ' . json_encode($review->errors));
        }
        return $review;
    }

    public function actionDelete($id)
    {
        $userId = Yii::$app->user->id;
        $review = Review::findOne(['id' => $id, 'user_id' => $userId]);

        if ($review === null) {
            throw new NotFoundHttpException("Review not found.");
        }

        if ($review->delete() === false) {
            throw new ServerErrorHttpException("Failed to delete review.");
        }

        return ['success' => true];
    }
}
