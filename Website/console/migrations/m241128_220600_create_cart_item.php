<?php

use yii\db\Migration;

/**
 * Class m241128_220600_create_cart_item
 */
class m241128_220600_create_cart_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart_item', [
            'cart_id' => $this->integer()->notNull(),
            'trade_proposal_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addPrimaryKey(
            'pk_cart_item',
            'cart_item',
            ['cart_id', 'trade_proposal_id']
        );

        $this->addForeignKey(
            'fk_cart_item_cart',
            'cart_item',
            'cart_id',
            'cart',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_cart_item_trade_proposal',
            'cart_item',
            'trade_proposal_id',
            'trade_proposal',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_220600_create_cart_item cannot be reverted.\n";

        return false;
    }
    */
}
