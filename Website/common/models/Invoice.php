<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $trade_id
 * @property int $user_info_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trade_id', 'user_info_id'], 'required'],
            [['trade_id', 'user_info_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_id' => 'Trade ID',
            'user_info_id' => 'User Info ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTrade()
    {
        return $this->hasOne(Trade::class, ['id' => 'trade_id']);
    }
}
