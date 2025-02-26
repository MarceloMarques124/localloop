<?php

use yii\db\Migration;

/**
 * Class m241126_222922_create_user_info
 */
class m241126_222922_create_user_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_info', [
            'id' => $this->integer()->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'address' => $this->string(200)->notNull(),
            'postal_code' => $this->string(8)->notNull(),
            'flagged_for_ban' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB');

        $this->addPrimaryKey('pk_user_info_id', 'user_info', 'id');

        $this->addForeignKey(
            'fk_user_info_user',
            'user_info',
            'id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_info');
    }
}
