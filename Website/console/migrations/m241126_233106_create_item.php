<?php

use yii\db\Migration;

/**
 * Class m241126_233106_create_item
 */
class m241126_233106_create_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'sub_category_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_item_user_info',
            'item',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_item_sub_category',
            'item',
            'sub_category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241126_233106_create_item cannot be reverted.\n";

        return false;
    }
    */
}
