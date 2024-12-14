<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $user_info_id
 * @property int|null $trade_id
 * @property int|null $advertisement_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Advertisement $advertisement
 * @property UserInfo $author
 * @property Trade $trade
 * @property UserInfo $userInfo
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id'], 'required'],
            [['author_id', 'user_info_id', 'trade_id', 'advertisement_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['advertisement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::class, 'targetAttribute' => ['advertisement_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['author_id' => 'id']],
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
            'author_id' => 'Author ID',
            'user_info_id' => 'User Info ID',
            'trade_id' => 'Trade ID',
            'advertisement_id' => 'Advertisement ID',
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
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'author_id']);
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
