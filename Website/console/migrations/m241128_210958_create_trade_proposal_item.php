<?php

use yii\db\Migration;

/**
 * Class m241128_210958_create_trade_proposal_item
 */
class m241128_210958_create_trade_proposal_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('trade_proposal_item', [
            'trade_proposal_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addPrimaryKey(
            'pk_trade_proposal_item',
            'trade_proposal_item',
            ['trade_proposal_id', 'item_id']
        );

        $this->addForeignKey(
            'fk_trade_proposal_item_trade_proposal',
            'trade_proposal_item',
            'trade_proposal_id',
            'trade_proposal',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_trade_proposal_item_item',
            'trade_proposal_item',
            'item_id',
            'item',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('trade_proposal_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_210958_create_trade_proposal_item cannot be reverted.\n";

        return false;
    }
    */
}
