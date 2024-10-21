<?php

namespace common\models;

use Yii;

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
}
