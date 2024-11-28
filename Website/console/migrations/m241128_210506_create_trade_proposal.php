<?php

use yii\db\Migration;

/**
 * Class m241128_210506_create_trade_proposal
 */
class m241128_210506_create_trade_proposal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('trade_proposal', [
            'id' => $this->primaryKey(),
            'trade_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull()->defaultValue(0),
            'message' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_trade_proposal_trade',
            'trade_proposal',
            'trade_id',
            'trade',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('trade_proposal');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_210506_create_trade_proposal cannot be reverted.\n";

        return false;
    }
    */
}
