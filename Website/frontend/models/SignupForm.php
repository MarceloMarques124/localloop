<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserInfo;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /* user info */
    public $name;
    public $address;
    public $postal_code;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 2, 'max' => 255],

            ['postal_code', 'trim'],
            ['postal_code', 'unique', 'targetClass' => '\common\models\UserInfo'],
            ['postal_code', 'required'],
            ['postal_code', 'string', 'max' => 10],
            ['postal_code', 'match', 'pattern' => '/\b\d{4}\b-\b\d{3}\b/'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;
        $user->save();

        $userInfo = new UserInfo();
        $userInfo->name = $this->name;
        $userInfo->address = $this->address;
        $userInfo->postal_code = $this->postal_code;
        $userInfo->id = $user->id;
        $userInfo->save();

        /* se ñ houver assign da role admin faz assign admin se ñ faz assign user */
        $auth = \Yii::$app->authManager;
        $existingAdmins = $auth->getUserIdsByRole('admin');
        $role = empty($existingAdmins) ? 'admin' : 'user';
        $authorRole = $auth->getRole($role);

        $auth->assign($authorRole, $user->getId());

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
