<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Trade extends ActiveRecord
{
    const STATE_PENDING = 0;
    const STATE_ACCEPTED = 1;
    const STATE_REJECTED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trade';
    }

    public static function getTotalTrades()
    {
        return self::find()->count();
    }

    public static function getTotalTradesToday()
    {
        $startOfDay = date('Y-m-d 00:00:00'); // Início do dia atual
        $endOfDay = date('Y-m-d 23:59:59');   // Fim do dia atual

        return self::find()
            ->where(['between', 'created_at', $startOfDay, $endOfDay])
            ->count();
    }

    public static function getTotalTradesOpen()
    {
        return self::find()->where(['state' => 0])->count();
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
            'advertisement_id' => 'Advertisement title',
            'user_info_id' => 'Username',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Advertisement]].
     *
     * @return ActiveQuery
     */
    public function getAdvertisement()
    {
        return $this->hasOne(Advertisement::class, ['id' => 'advertisement_id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::class, ['trade_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['trade_id' => 'id']);
    }

    /**
     * Gets query for [[TradeProposals]].
     *
     * @return ActiveQuery
     */
    public function getTradeProposals()
    {
        return $this->hasMany(TradeProposal::class, ['trade_id' => 'id']);
    }

    /**
     * Gets query for [[UserInfo]].
     *
     * @return ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'user_info_id']);
    }
}
