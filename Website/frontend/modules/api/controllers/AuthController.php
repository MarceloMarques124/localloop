<?php

namespace frontend\modules\api\controllers;

use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends ActiveController
{
    public $modelClass = UserInfo::class;

    /**
     * @throws UnauthorizedHttpException
     * @throws BadRequestHttpException
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        if (empty($username) || empty($password)) {
            throw new BadRequestHttpException('Username and password are required.');
        }

        $user = User::findByUsername($username);
        if (!$user || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Invalid username or password.');
        }

        return $user->getAuthKey();
    }
}