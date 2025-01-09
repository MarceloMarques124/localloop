<?php

use yii\db\Migration;

/**
 * Class m250109_160728_create_invoice
 */
class m250109_160728_create_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250109_160728_create_invoice cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250109_160728_create_invoice cannot be reverted.\n";

        return false;
    }
    */
}
