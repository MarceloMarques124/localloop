<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $user_info_id
 * @property int $sub_category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $subCategory
 * @property TradeProposalItem[] $tradeProposalItems
 * @property TradeProposal[] $tradeProposals
 * @property UserInfo $userInfo
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_info_id', 'sub_category_id'], 'required'],
            [['user_info_id', 'sub_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::class, 'targetAttribute' => ['sub_category_id' => 'id']],
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
            'name' => 'Item name',
            'user_info_id' => 'User Info',
            'sub_category_id' => 'Sub Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }

    /**
     * Gets query for [[TradeProposalItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTradeProposalItems()
    {
        return $this->hasMany(TradeProposalItem::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[TradeProposals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTradeProposals()
    {
        return $this->hasMany(TradeProposal::class, ['id' => 'trade_proposal_id'])->viaTable('trade_proposal_item', ['item_id' => 'id']);
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
