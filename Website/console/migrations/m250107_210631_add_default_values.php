<?php

use yii\db\Migration;

/**
 * Class m250107_210631_add_default_values
 */
class m250107_210631_add_default_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createAdvertisementReport();

        $this->createUserReport();
    }

    /**
     * @return void
     */
    public function createAdvertisementReport(): void
    {
        $this->insert('{{%advertisement}}', [
            'user_info_id' => 1,
            'title' => 'servico x',
        ]);

        $this->insert('{{%report}}', [
            'author_id' => 1,
            'advertisement_id' => 1,
        ]);
    }


    /**
     * @return void
     */
    public function createUserReport(): void
    {
        $this->insert('{{%report}}', [
            'author_id' => 1,
            'user_info_id' => 1,
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%report}}', ['user_info_id' => 1]);

        $this->delete('{{%report}}', ['advertisement_id' => 1]);

        $this->delete('{{%advertisement}}', ['user_info_id' => 1, 'title' => 'servico x']);
    }

}
