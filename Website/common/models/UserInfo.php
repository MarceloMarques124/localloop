<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $postal_code
 * @property int $flagged_for_ban
 */
class UserInfo extends ActiveRecord
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Username',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
        ];
    }

    // UserInfo model
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['user_info_id' => 'id']);
    }
}
