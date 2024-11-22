<?php

namespace backend\models;

use yii\base\Model;

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

    public $id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $this->id], 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $this->id], 'message' => 'This email address has already been taken.'],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 2, 'max' => 255],

            ['postal_code', 'trim'],
            ['postal_code', 'required'],
            ['postal_code', 'string', 'max' => 10],
            ['postal_code', 'match', 'pattern' => '/\b\d{4}\b-\b\d{3}\b/'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'username' => 'Username',
            'email' => 'Email',
        ];
    }
}
