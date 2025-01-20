<?php

namespace frontend\modules\api\controllers;

use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;
use yii\validators\EmailValidator;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
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

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionSignup()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');
        $email = $request->post('email');

        if (empty($username) || empty($password) || empty($email)) {
            throw new BadRequestHttpException('Username, password, and email are required.');
        }

        $emailValidator = new EmailValidator();
        if (!$emailValidator->validate($email)) {
            throw new BadRequestHttpException('The email format is invalid.');
        }

        if (User::findByUsername($username)) {
            throw new BadRequestHttpException('Username is already taken.');
        }

        if (User::findOne(['email' => $email])) {
            throw new BadRequestHttpException('Email is already registered.');
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        if (!$user->save()) {
            throw new ServerErrorHttpException('Failed to create the user for unknown reasons.');
        }
        
        return $user->getAuthKey();
    }

}