<?php

use yii\db\Migration;

/**
 * Class m250209_175009_seed_full_data
 */
class m250209_175009_seed_full_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $dt = '2025-02-09 12:00:00';


        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            // Ordem:
            'review',
            'cart_item',
            'cart',
            'saved_advertisement',
            'report',
            'invoice',
            'trade_proposal_item',
            'trade_proposal',
            'trade',
            'advertisement',
            'item',
            'sub_category',
            'category',
        ];
        foreach ($tables as $table) {
            $this->truncateTable($table);
        }
        $this->execute('SET FOREIGN_KEY_CHECKS=1');

        $this->batchInsert('category', ['id', 'name', 'created_at', 'updated_at'], [
            [1, 'Casa', $dt, $dt],
            [2, 'Carros', $dt, $dt],
            [3, 'Tecnologia', $dt, $dt],
            [4, 'Moda', $dt, $dt],
            [5, 'Esportes', $dt, $dt],
        ]);

        $this->batchInsert('sub_category', ['id', 'name', 'category_id', 'created_at', 'updated_at'], [
            [1, 'Móveis', 1, $dt, $dt],
            [2, 'Decoração', 1, $dt, $dt],
            [3, 'Fiat', 2, $dt, $dt],
            [4, 'Renault', 2, $dt, $dt],
            [5, 'Computadores', 3, $dt, $dt],
            [6, 'Smartphones', 3, $dt, $dt],
        ]);


        $this->batchInsert('item', ['id', 'name', 'user_info_id', 'sub_category_id', 'created_at', 'updated_at'], [
            [1, 'Sofá', 1, 1, $dt, $dt],
            [2, 'Mesa de Jantar', 1, 2, $dt, $dt],
            [3, 'Carro Fiat 500', 2, 3, $dt, $dt],
            [4, 'Carro Renault Clio', 2, 4, $dt, $dt],
            [5, 'Laptop', 1, 5, $dt, $dt],
            [6, 'iPhone', 2, 6, $dt, $dt],
        ]);

        $this->batchInsert('advertisement', ['id', 'user_info_id', 'title', 'description', 'is_service', 'created_at', 'updated_at'], [
            [1, 1, 'Serviço de Limpeza', 'Limpeza residencial', 1, $dt, $dt],
            [2, 1, 'Venda de Sofá', 'Sofá em bom estado', 0, $dt, $dt],
            [3, 2, 'Troca de Carro', 'Troca de carro Fiat', 0, $dt, $dt],
            [4, 2, 'Serviço de Conserto', 'Conserto de carros Renault', 1, $dt, $dt],
            [5, 1, 'Venda de Laptop', 'Laptop quase novo', 0, $dt, $dt],
            [6, 2, 'Venda de iPhone', 'iPhone 12 à venda', 0, $dt, $dt],
        ]);


        $this->batchInsert('trade', ['id', 'advertisement_id', 'user_info_id', 'state', 'created_at', 'updated_at'], [
            [1, 1, 2, 0, $dt, $dt],
            [2, 2, 2, 1, $dt, $dt],
            [3, 3, 1, 0, $dt, $dt],
            [4, 4, 1, 1, $dt, $dt],
            [5, 5, 2, 0, $dt, $dt],
            [6, 6, 1, 1, $dt, $dt],
        ]);

        $this->batchInsert('trade_proposal', ['id', 'trade_id', 'state', 'message', 'created_at', 'updated_at'], [
            [1, 1, 0, 'Proposta para trade 1', $dt, $dt],
            [2, 2, 1, 'Proposta para trade 2', $dt, $dt],
            [3, 3, 0, 'Proposta para trade 3', $dt, $dt],
            [4, 4, 1, 'Proposta para trade 4', $dt, $dt],
            [5, 5, 0, 'Proposta para trade 5', $dt, $dt],
            [6, 6, 1, 'Proposta para trade 6', $dt, $dt],
        ]);


        $this->batchInsert('trade_proposal_item', ['trade_proposal_id', 'item_id', 'created_at', 'updated_at'], [
            [1, 1, $dt, $dt],
            [2, 2, $dt, $dt],
            [3, 3, $dt, $dt],
            [4, 4, $dt, $dt],
            [5, 5, $dt, $dt],
            [6, 6, $dt, $dt],
        ]);


        $this->batchInsert('invoice', ['id', 'trade_id', 'user_info_id', 'created_at', 'updated_at'], [
            [1, 1, 2, $dt, $dt],
            [2, 2, 2, $dt, $dt],
            [3, 3, 1, $dt, $dt],
            [4, 4, 1, $dt, $dt],
            [5, 5, 2, $dt, $dt],
            [6, 6, 1, $dt, $dt],
        ]);


        $this->batchInsert('report', ['id', 'author_id', 'user_info_id', 'trade_id', 'advertisement_id', 'created_at', 'updated_at'], [
            [1, 1, 2, 1, 1, $dt, $dt],
            [2, 2, 1, 2, 2, $dt, $dt],
            [3, 1, 2, 3, 3, $dt, $dt],
            [4, 2, 1, 4, 4, $dt, $dt],
            [5, 1, 2, 5, 5, $dt, $dt],
            [6, 2, 1, 6, 6, $dt, $dt],
        ]);


        $this->batchInsert('saved_advertisement', ['user_info_id', 'advertisement_id', 'created_at', 'updated_at'], [
            [1, 2, $dt, $dt],
            [2, 3, $dt, $dt],
            [1, 4, $dt, $dt],
            [2, 5, $dt, $dt],
            [1, 6, $dt, $dt],
            [2, 1, $dt, $dt],
        ]);


        $this->batchInsert('cart', ['id', 'state', 'created_at', 'updated_at'], [
            [1, 0, $dt, $dt],
            [2, 0, $dt, $dt],
        ]);


        $this->batchInsert('cart_item', ['cart_id', 'advertisement_id', 'created_at', 'updated_at'], [
            [1, 3, $dt, $dt],
            [2, 4, $dt, $dt],
        ]);

        $this->batchInsert('review', ['id', 'user_info_id', 'trade_id', 'title', 'message', 'stars', 'created_at', 'updated_at'], [
            [1, 1, 1, 'Ótimo serviço', 'Muito satisfeito', 5, $dt, $dt],
            [2, 2, 2, 'Bom produto', 'Conforme esperado', 4, $dt, $dt],
            [3, 1, 3, 'Mau', 'Não gostei', 2, $dt, $dt],
            [4, 2, 4, 'Excelente', 'Recomendo', 5, $dt, $dt],
            [5, 1, 5, 'Regular', 'Poderia ser melhor', 3, $dt, $dt],
            [6, 2, 6, 'Satisfatório', 'Cumpriu o combinado', 4, $dt, $dt],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'review',
            'cart_item',
            'cart',
            'saved_advertisement',
            'report',
            'invoice',
            'trade_proposal_item',
            'trade_proposal',
            'trade',
            'advertisement',
            'item',
            'sub_category',
            'category',
        ];
        foreach ($tables as $table) {
            $this->truncateTable($table);
        }
        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }
}
