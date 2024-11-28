<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m241128_223308_add_default_admin_user
 */
class m241128_223308_add_default_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $userId = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->scalar();
        
        if (!$userId) {

            $adminUser = [
                'username' => 'admin',
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash('adminadmin'),
                'email' => 'admin@admin.com',
                'status' => 10,
                'created_at' => time(),
                'updated_at' => time(),
                'verification_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            ];


            $this->insert('{{%user}}', $adminUser);


            $userId = Yii::$app->db->getLastInsertID();
        }

        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');

        $existingAssignment = (new Query())
            ->from('{{%auth_assignment}}')
            ->where(['user_id' => $userId, 'item_name' => 'admin'])
            ->exists();

        if (!$existingAssignment) {
            $auth->assign($adminRole, $userId);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $userId = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->scalar();

        if ($userId) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($userId);
        }

        $this->delete('{{%user}}', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_223308_add_default_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
