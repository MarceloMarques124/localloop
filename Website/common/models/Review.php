<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $user_info_id
 * @property int $trade_id
 * @property string $title
 * @property string $message
 * @property int $stars
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Trade $trade
 * @property UserInfo $userInfo
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_info_id', 'trade_id', 'title', 'message', 'stars'], 'required'],
            [['user_info_id', 'trade_id', 'stars'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'message'], 'string', 'max' => 255],
            [['trade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trade::class, 'targetAttribute' => ['trade_id' => 'id']],
            [['user_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['user_info_id' => 'id']],
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
            'trade_id' => 'Trade ID',
            'title' => 'Title',
            'message' => 'Message',
            'stars' => 'Stars',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Trade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrade()
    {
        return $this->hasOne(Trade::class, ['id' => 'trade_id']);
    }

    /**
     * Gets query for [[UserInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'user_info_id']);
    }
}
