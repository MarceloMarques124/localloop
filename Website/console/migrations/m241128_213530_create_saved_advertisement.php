<?php

use yii\db\Migration;

/**
 * Class m241128_213530_create_saved_advertisement
 */
class m241128_213530_create_saved_advertisement extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('saved_advertisement', [
            'user_info_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addPrimaryKey(
            'pk_saved_advertisement',
            'saved_advertisement',
            ['user_info_id', 'advertisement_id']
        );

        $this->addForeignKey(
            'fk_saved_advertisement_user_info',
            'saved_advertisement',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_saved_advertisement_advertisement',
            'saved_advertisement',
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
        echo "m241128_213530_create_saved_advertisement cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_213530_create_saved_advertisement cannot be reverted.\n";

        return false;
    }
    */
}
