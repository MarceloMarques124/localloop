<?php

use yii\db\Migration;

/**
 * Class m241128_214301_create_cart
 */
class m241128_214301_create_cart extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart', [
            'id' => $this->integer()->notNull()->unique(),
            'state' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addPrimaryKey('pk_cart_user_info', 'cart', 'id');

        $this->addForeignKey(
            'fk_cart_user_info',
            'cart',
            'id',
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
        echo "m241128_214301_create_cart cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_214301_create_cart cannot be reverted.\n";

        return false;
    }
    */
}
