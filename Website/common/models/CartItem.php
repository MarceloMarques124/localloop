<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart_item".
 *
 * @property int $cart_id
 * @property int $trade_proposal_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Cart $cart
 * @property TradeProposal $tradeProposal
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'trade_proposal_id'], 'required'],
            [['cart_id', 'trade_proposal_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cart_id', 'trade_proposal_id'], 'unique', 'targetAttribute' => ['cart_id', 'trade_proposal_id']],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::class, 'targetAttribute' => ['cart_id' => 'id']],
            [['trade_proposal_id'], 'exist', 'skipOnError' => true, 'targetClass' => TradeProposal::class, 'targetAttribute' => ['trade_proposal_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cart_id' => 'Cart ID',
            'trade_proposal_id' => 'Trade Proposal ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart_id']);
    }

    /**
     * Gets query for [[TradeProposal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTradeProposal()
    {
        return $this->hasOne(TradeProposal::class, ['id' => 'trade_proposal_id']);
    }
}
