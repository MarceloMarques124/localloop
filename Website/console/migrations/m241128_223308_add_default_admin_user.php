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
        // Add default admin user
        $adminUserId = $this->addUser('admin', 'admin@admin.com', 'adminadmin', 'admin user', 'rua admin', '1234-123');
        $this->assignRole($adminUserId, 'admin');

        // Add default reviewer user
        $reviewerUserId = $this->addUser('reviewer', 'reviewer@domain.com', 'reviewerpass', 'reviewer user', 'rua reviewer', '1234-123');
        $this->assignRole($reviewerUserId, 'reviwer');
    }

    /**
     * Adds a user to the database
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $name
     * @return int|null The user ID
     */
    protected function addUser($username, $email, $password, $name, $address, $postal_code)
    {
        $userId = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => $username])
            ->scalar();

        if (!$userId) {
            $user = [
                'username' => $username,
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash($password),
                'email' => $email,
                'status' => 10,
                'created_at' => time(),
                'updated_at' => time(),
                'verification_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            ];

            $this->insert('{{%user}}', $user);
            $userId = Yii::$app->db->getLastInsertID();

            $userInfo = [
                'id' => $userId,
                'name' => $name,
                'address' => $address,
                'postal_code' => $postal_code,
            ];

            $this->insert('{{%user_info}}', $userInfo);
        }

        return $userId;
    }

    /**
     * Assigns a role to a user
     *
     * @param int $userId
     * @param string $roleName
     */
    protected function assignRole($userId, $roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);

        $existingAssignment = (new Query())
            ->from('{{%auth_assignment}}')
            ->where(['user_id' => $userId, 'item_name' => $roleName])
            ->exists();

        if (!$existingAssignment && $role) {
            $auth->assign($role, $userId);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->removeUser('admin');
        $this->removeUser('reviewer');
    }

    /**
     * Removes a user and their role assignments
     *
     * @param string $username
     */
    protected function removeUser($username)
    {
        $userId = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => $username])
            ->scalar();

        if ($userId) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($userId);
            $this->delete('{{%user_info}}', ['id' => $userId]);
            $this->delete('{{%user}}', ['id' => $userId]);
        }
    }
}
