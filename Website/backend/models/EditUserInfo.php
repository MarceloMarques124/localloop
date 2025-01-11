<?php

namespace backend\models;

use yii\base\Model;

/**
 * Signup form
 */
class EditUserInfo extends Model
{
    public $role;

    /* user data */
    public $username;
    public $email;
    public $password;

    /* user info data */
    public $name;
    public $address;
    public $postal_code;

    public $id;

    public function scenarios()
    {
        return [
            'create' => ['username', 'email', 'name', 'address', 'postal_code'],
            'update' => ['username', 'email', 'name', 'address', 'postal_code', 'id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'safe'],

            ['username', 'trim', 'skipOnEmpty' => false],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.', 'on' => 'create'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['not', ['id' => $this->id]], 'message' => 'This username has already been taken.', 'on' => 'update'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim', 'skipOnEmpty' => false],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email has already been taken.', 'on' => 'create'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['not', ['id' => $this->id]], 'message' => 'This email has already been taken.', 'on' => 'update'],

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
