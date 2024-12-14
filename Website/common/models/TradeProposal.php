<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trade_proposal".
 *
 * @property int $id
 * @property int $trade_id
 * @property int $state
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CartItem[] $cartItems
 * @property Cart[] $carts
 * @property Item[] $items
 * @property Trade $trade
 * @property TradeProposalItem[] $tradeProposalItems
 */
class TradeProposal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trade_proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trade_id', 'message'], 'required'],
            [['trade_id', 'state'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['trade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trade::class, 'targetAttribute' => ['trade_id' => 'id']],
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
            'state' => 'State',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['trade_proposal_id' => 'id']);
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['id' => 'cart_id'])->viaTable('cart_item', ['trade_proposal_id' => 'id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])->viaTable('trade_proposal_item', ['trade_proposal_id' => 'id']);
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
     * Gets query for [[TradeProposalItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTradeProposalItems()
    {
        return $this->hasMany(TradeProposalItem::class, ['trade_proposal_id' => 'id']);
    }
}
