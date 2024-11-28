<?php

use yii\db\Migration;

/**
 * Class m241128_205546_create_trade
 */
class m241128_205546_create_trade extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('trade', [
            'id' => $this->primaryKey(),
            'advertisement_id' => $this->integer()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_trade_advertisement',
            'trade',
            'advertisement_id',
            'advertisement',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_trade_user_info',
            'trade',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('trade');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_205546_create_trade cannot be reverted.\n";

        return false;
    }
    */
}
