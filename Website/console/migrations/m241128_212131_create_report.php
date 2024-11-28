<?php

use yii\db\Migration;

/**
 * Class m241128_212131_create_report
 */
class m241128_212131_create_report extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'user_info_id' => $this->integer(),
            'trade_id' => $this->integer(),
            'advertisement_id' => $this->integer(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_report_author',
            'report',
            'author_id',
            'user_info',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_user_info',
            'report',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_trade',
            'report',
            'trade_id',
            'trade',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_advertisement',
            'report',
            'advertisement_id',
            'advertisement',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('report');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_212131_create_report cannot be reverted.\n";

        return false;
    }
    */
}
