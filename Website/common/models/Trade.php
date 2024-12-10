<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trade".
 *
 * @property int $id
 * @property int $advertisement_id
 * @property int $user_info_id
 * @property int $state
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Advertisement $advertisement
 * @property Report[] $reports
 * @property Review[] $reviews
 * @property TradeProposal[] $tradeProposals
 * @property UserInfo $userInfo
 */
class Trade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['advertisement_id', 'user_info_id'], 'required'],
            [['advertisement_id', 'user_info_id', 'state'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['advertisement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::class, 'targetAttribute' => ['advertisement_id' => 'id']],
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
            'advertisement_id' => 'Advertisement ID',
            'user_info_id' => 'User Info ID',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Advertisement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisement()
    {
        return $this->hasOne(Advertisement::class, ['id' => 'advertisement_id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::class, ['trade_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['trade_id' => 'id']);
    }

    /**
     * Gets query for [[TradeProposals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTradeProposals()
    {
        return $this->hasMany(TradeProposal::class, ['trade_id' => 'id']);
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
