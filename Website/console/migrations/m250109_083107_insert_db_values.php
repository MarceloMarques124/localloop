<?php

use yii\db\Migration;

/**
 * Class m250109_083107_insert_db_values
 */
class m250109_083107_insert_db_values extends Migration
{
    public function safeUp()
    {
        $this->insert('user', [
            'id' => 3,
            'username' => 'test_user',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('password123'),
            'email' => 'test_user@example.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('user_info', [
            'id' => 3,
            'name' => 'Test User',
            'address' => '123 Test Street',
            'postal_code' => '12345',
            'flagged_for_ban' => 0,
        ]);

        $categories = [
            ['id' => 1, 'name' => 'Casa'],
            ['id' => 2, 'name' => 'Carros'],
            ['id' => 3, 'name' => 'Tecnologia'],
            ['id' => 4, 'name' => 'Moda'],
        ];

        foreach ($categories as $category) {
            $this->insert('category', $category);
        }

        $subCategories = [
            ['id' => 1, 'name' => 'Móveis', 'category_id' => 1],
            ['id' => 2, 'name' => 'Decoração', 'category_id' => 1],
            ['id' => 3, 'name' => 'Fiat', 'category_id' => 2],
            ['id' => 4, 'name' => 'Renault', 'category_id' => 2],
            ['id' => 5, 'name' => 'Telemovel', 'category_id' => 3],
            ['id' => 6, 'name' => 'Computadores', 'category_id' => 3],
            ['id' => 7, 'name' => 'Roupas', 'category_id' => 4],
            ['id' => 8, 'name' => 'Acessórios', 'category_id' => 4],
        ];

        foreach ($subCategories as $subCategory) {
            $this->insert('sub_category', $subCategory);
        }

        for ($i = 2; $i <= 10; $i++) {
            $this->insert('advertisement', [
                'id' => $i,
                'user_info_id' => 3,
                'title' => "Anúncio de Teste #$i",
                'description' => "Descrição do anúncio de teste #$i",
                'is_service' => $i % 2 == 0,
            ]);
        }
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('user');
        $auth->assign($authorRole, 3);
    }

    public function safeDown()
    {
        // Remover os dados inseridos
        $this->delete('advertisement', ['user_info_id' => 3]);
        $this->delete('sub_category');
        $this->delete('category');
        $this->delete('user_info', ['id' => 3]);
        $this->delete('user', ['id' => 3]);
    }
}
