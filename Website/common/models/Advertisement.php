<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "advertisement".
 *
 * @property int $id
 * @property int $user_info_id
 * @property string $title
 * @property string|null $description
 * @property int $is_service
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Report[] $reports
 * @property SavedAdvertisement[] $savedAdvertisements
 * @property Trade[] $trades
 * @property UserInfo $userInfo
 * @property UserInfo[] $userInfos
 */
class Advertisement extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement';
    }

    public static function getTotalAdvertisements()
    {
        return self::find()->count();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_info_id', 'title'], 'required'],
            [['user_info_id', 'is_service'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'description' => 'Description',
            'is_service' => 'Is Service',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::class, ['advertisement_id' => 'id']);
    }

    /**
     * Gets query for [[SavedAdvertisements]].
     *
     * @return ActiveQuery
     */
    public function getSavedAdvertisements()
    {
        return $this->hasMany(SavedAdvertisement::class, ['advertisement_id' => 'id']);
    }

    /**
     * Gets query for [[Trades]].
     *
     * @return ActiveQuery
     */
    public function getTrades()
    {
        return $this->hasMany(Trade::class, ['advertisement_id' => 'id']);
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

    /**
     * Gets query for [[UserInfos]].
     *
     * @return ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::class, ['id' => 'user_info_id'])->viaTable('saved_advertisement', ['advertisement_id' => 'id']);
    }
}
