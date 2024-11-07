<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserInfo;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

/**
 * Signup form
 */
class EditUserInfo extends Model
{
    /* user data */
    public $username;
    public $email;
    public $password;

    /* user info data */
    public $name;
    public $address;
    public $postal_code;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $idUser = \Yii::$app->request->post('id');
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $idUser], 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $idUser], 'message' => 'This email address has already been taken.'],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 2, 'max' => 255],

            ['postal_code', 'trim'],
            ['postal_code', 'unique', 'targetClass' => '\common\models\UserInfo', 'filter' => ['<>', 'id', $idUser], 'message' => 'This postal code has already been taken.'],
            ['postal_code', 'required'],
            ['postal_code', 'string', 'max' => 10],
            ['postal_code', 'match', 'pattern' => '/\b\d{4}\b-\b\d{3}\b/'],

        ];
    }

    public static function saveUserInfo($id, $userData)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $id = \Yii::$app->request->post('id');
        $userDataString = \Yii::$app->request->post('userData');
        parse_str($userDataString, $userData);

        // Localize os modelos reais
        $user = User::findOne($id);
        $userInfo = UserInfo::findOne($id);

        if ($user && $userInfo) {
            // Carrega os dados no modelo `EditUserInfo`
            $editUserInfo = new EditUserInfo();
            $editUserInfo->username = $userData['username'];
            $editUserInfo->email = $userData['email'];
            $editUserInfo->name = $userData['name'];
            $editUserInfo->address = $userData['address'];
            $editUserInfo->postal_code = $userData['postal_code'];

            // Valida antes de salvar
            if ($editUserInfo->validate()) {
                // Carregar valores validados nos modelos reais
                $user->username = $editUserInfo->username;
                $user->email = $editUserInfo->email;
                $userInfo->name = $editUserInfo->name;
                $userInfo->address = $editUserInfo->address;
                $userInfo->postal_code = $editUserInfo->postal_code;

                // Salva os modelos reais somente se todos os dados estiverem válidos
                if ($user->save() && $userInfo->save()) {
                    return ['success' => true, 'message' => 'User information saved successfully.', 'username' => $user->username];
                } else {
                    return [
                        'success' => false,
                        'errors' => array_merge($user->getErrors(), $userInfo->getErrors())
                    ];
                }
            } else {
                // Retorna os erros de validação de `EditUserInfo`
                return [
                    'success' => false,
                    'errors' => $editUserInfo->getErrors()
                ];
            }
        }

        throw new NotFoundHttpException('User not found.');
    }
}
