<?php

use yii\db\Migration;

/**
 * Class m241024_202254_rbac
 */
class m241024_202254_rbac extends Migration
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
        echo "m241024_202254_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241024_202254_rbac cannot be reverted.\n";

        return false;
    }
    */
}
