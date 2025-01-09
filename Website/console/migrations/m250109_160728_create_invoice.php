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
        // Cria a tabela invoice
        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(), // Chave primária
            'trade_id' => $this->integer()->notNull(), // Relacionada à trade
            'user_info_id' => $this->integer()->notNull(), // Relacionada ao usuário
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'), // Data de criação
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'), // Última atualização
        ]);

        // Adiciona a chave estrangeira para a tabela trade
        $this->addForeignKey(
            'fk-invoice-trade_id',
            '{{%invoice}}',
            'trade_id',
            '{{%trade}}',
            'id',
            'CASCADE'
        );

        // Adiciona a chave estrangeira para a tabela user_info
        $this->addForeignKey(
            'fk-invoice-user_info_id',
            '{{%invoice}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove as chaves estrangeiras
        $this->dropForeignKey('fk-invoice-trade_id', '{{%invoice}}');
        $this->dropForeignKey('fk-invoice-user_info_id', '{{%invoice}}');

        // Remove a tabela invoice
        $this->dropTable('{{%invoice}}');
    }
}
