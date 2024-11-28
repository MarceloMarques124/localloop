<?php

use yii\db\Migration;

/**
 * Class m241126_232236_create_sub_category
 */
class m241126_232236_create_sub_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sub_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_sub_category_category',
            'sub_category',
            'category_id',
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
        $this->dropTable('sub_category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241126_232236_create_sub_category cannot be reverted.\n";

        return false;
    }
    */
}
