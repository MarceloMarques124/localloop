<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertisement".
 *
 * @property int $id
 * @property int $user_info_id
 * @property string|null $description
 * @property int $is_service
 * @property string $created_date
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_service'], 'required'],
            [['user_info_id', 'is_service'], 'integer'],
            [['created_date'], 'safe'],
            [['description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_info_id' => 'User Info ID',
            'description' => 'Description',
            'is_service' => 'Service / Item',
            'created_date' => 'Created Date',
        ];
    }
}
