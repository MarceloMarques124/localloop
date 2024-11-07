<?php

namespace common\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $postal_code
 * @property int $flagged_for_ban
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'address', 'postal_code'], 'required'],
            [['id', 'flagged_for_ban'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 200],
            [['postal_code'], 'string', 'max' => 8],
            [['id'], 'unique'],
            ['postal_code', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'flagged_for_ban' => 'Flagged For Ban',
        ];
    }

    public static function getUserInfo($id)
    {
        $user = User::findOne($id);
        $userInfo = UserInfo::findOne($id);

        if ($user) {
            return [
                'username' => $user->username,
                'email' => $user->email,
                'name' => $userInfo->name,
                'address' => $userInfo->address,
                'postal_code' => $userInfo->postal_code,
            ];
        }
        throw new NotFoundHttpException('User not found.');
    }

    public static function saveUserInfo($id, $userData)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user = User::findOne($id);
        $userInfo = UserInfo::findOne($id);

        if ($user && $userInfo) {
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $userInfo->name = $userData['name'];
            $userInfo->address = $userData['address'];
            $userInfo->postal_code = $userData['postal_code'];

            if ($user->validate() && $userInfo->validate()) {
                if ($user->save() && $userInfo->save()) {
                    return ['success' => true, 'message' => 'User information saved successfully.'];
                }
            } else {
                // Retornar os erros de validação no formato JSON
                var_dump($user->errors, $userInfo->getErrors());
                die;
                return [
                    'success' => false,
                    'errors' => array_merge(
                        $user->getErrors(),
                        //$userInfo->getErrors()
                    )
                ];
            }
        } else {
            throw new NotFoundHttpException('User not found.');
        }
    }
}
