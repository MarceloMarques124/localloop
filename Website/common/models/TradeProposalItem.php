<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trade_proposal_item".
 *
 * @property int $trade_proposal_id
 * @property int $item_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item $item
 * @property TradeProposal $tradeProposal
 */
class TradeProposalItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trade_proposal_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trade_proposal_id', 'item_id'], 'required'],
            [['trade_proposal_id', 'item_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['trade_proposal_id', 'item_id'], 'unique', 'targetAttribute' => ['trade_proposal_id', 'item_id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
            [['trade_proposal_id'], 'exist', 'skipOnError' => true, 'targetClass' => TradeProposal::class, 'targetAttribute' => ['trade_proposal_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'trade_proposal_id' => 'Trade Proposal ID',
            'item_id' => 'Item name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
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
