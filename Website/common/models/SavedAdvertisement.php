<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "saved_advertisement".
 *
 * @property int $user_info_id
 * @property int $advertisement_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Advertisement $advertisement
 * @property UserInfo $userInfo
 */
class SavedAdvertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saved_advertisement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_info_id', 'advertisement_id'], 'required'],
            [['user_info_id', 'advertisement_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_info_id', 'advertisement_id'], 'unique', 'targetAttribute' => ['user_info_id', 'advertisement_id']],
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
            'user_info_id' => 'User Info ID',
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
     * Gets query for [[UserInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'user_info_id']);
    }
}
