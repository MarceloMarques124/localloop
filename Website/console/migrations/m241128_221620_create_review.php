<?php

use yii\db\Migration;

/**
 * Class m241128_221620_create_review
 */
class m241128_221620_create_review extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'user_info_id' => $this->integer()->notNull(),
            'trade_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'message' => $this->string()->notNull(),
            'stars' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_review_user_info',
            'review',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_review_trade',
            'review',
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
        $this->dropTable('review');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_221620_create_review cannot be reverted.\n";

        return false;
    }
    */
}
