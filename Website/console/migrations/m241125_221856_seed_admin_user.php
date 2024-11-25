<?php

use yii\db\Migration;

/**
 * Class m241125_221856_seed_admin_user
 */
class m241125_221856_seed_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Define the admin user data
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

        // Insert the admin user into the user table
        $this->insert('{{%user}}', $adminUser);

        // Get the last inserted ID
        $userId = Yii::$app->db->getLastInsertID();

        // Assign the admin role to the user
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, $userId); // Use the retrieved user ID
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove the admin user by username
        $userId = (new \yii\db\Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->scalar();

        if ($userId) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($userId); // Revoke all roles for this user
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
        echo "m241125_221856_seed_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
