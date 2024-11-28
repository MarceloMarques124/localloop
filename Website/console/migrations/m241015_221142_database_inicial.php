<?php

use yii\db\Migration;

/**
 * Class m241015_221142_database_inicial
 */
class m241015_221142_database_inicial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // Table `user_info`
        $this->createTable('{{%user_info}}', [
            'id' => $this->integer()->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'address' => $this->string(200)->notNull(),
            'postal_code' => $this->string(8)->notNull(),
            'flagged_for_ban' => $this->boolean()->notNull()->defaultValue(0),
        ]);
        $this->addPrimaryKey('pk_user_info_id', '{{%user_info}}', 'id');

        // Table `category`
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(50)->notNull(),
        ]);

        // Table `trade`
        $this->createTable('{{%trade}}', [
            'id' => $this->primaryKey()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull(),
            'message' => $this->string(500)->notNull(),
        ]);

        // Table `advertisement`
        $this->createTable('{{%advertisement}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'description' => $this->string(250),
            'is_service' => $this->boolean()->notNull(),
            'created_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Table `trade_proposal_item`
        $this->createTable('{{%trade_proposal_item}}', [
            'trade_proposal_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
        ]);

        // Table `item`
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        // Table `review`
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'trade_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'message' => $this->text()->notNull(),
            'star_count' => $this->integer()->notNull(),
            'created_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Table `report`
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'user_info_id' => $this->integer(),
            'trade_id' => $this->integer(),
            'advertisement_id' => $this->integer(),
            'reason' => $this->integer()->notNull(),
            'message' => $this->string(1000),
        ]);

        // Table `trade_proposal`
        $this->createTable('{{%trade_proposal}}', [
            'id' => $this->primaryKey()->notNull(),
            'trade_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull(),
            'message' => $this->string(1000),
            'created_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Table `cart_item`
        $this->createTable('{{%cart_item}}', [
            'cart_id' => $this->integer()->notNull(),
            'trade_proposal_id' => $this->integer()->notNull(),
        ]);

        // Table `saved_advertisement`
        $this->createTable('{{%saved_advertisement}}', [
            'user_info_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
        ]);

        // Add foreign key for `user_info` referencing `user`
        $this->addForeignKey(
            'fk_user_info_user',
            '{{%user_info}}',
            'id',
            '{{%user}}',
            'id',
            'CASCADE'
        );



        // Foreign key for `advertisement` to `user_info`
        $this->addForeignKey(
            'fk_advertisement_user_info_id',
            '{{%advertisement}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );



        // Foreign keys for `trade`
        $this->addForeignKey(
            'fk_trade_advertisement_id',
            '{{%trade}}',
            'advertisement_id',
            '{{%advertisement}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_trade_user_info_id',
            '{{%trade}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );


        $this->addPrimaryKey('pk_trade_proposal_item', '{{%trade_proposal_item}}', ['trade_proposal_id', 'item_id']);

        // Foreign keys for `trade_proposal_item`
        $this->addForeignKey(
            'fk_trade_proposal_item_trade_proposal_id',
            '{{%trade_proposal_item}}',
            'trade_proposal_id',
            '{{%trade_proposal}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_trade_proposal_item_item_id',
            '{{%trade_proposal_item}}',
            'item_id',
            '{{%item}}',
            'id',
            'CASCADE'
        );



        // Foreign keys for `item`
        $this->addForeignKey(
            'fk_item_user_info_id',
            '{{%item}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_item_category_id',
            '{{%item}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );


        // Foreign keys for `review`
        $this->addForeignKey(
            'fk_review_user_info_id',
            '{{%review}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_review_trade_id',
            '{{%review}}',
            'trade_id',
            '{{%trade}}',
            'id',
            'CASCADE'
        );



        // Foreign keys for `report`
        $this->addForeignKey(
            'fk_report_author_id',
            '{{%report}}',
            'author_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_user_info_id',
            '{{%report}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_trade_id',
            '{{%report}}',
            'trade_id',
            '{{%trade}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_report_advertisement_id',
            '{{%report}}',
            'advertisement_id',
            '{{%advertisement}}',
            'id',
            'CASCADE'
        );



        // Foreign key for `trade_proposal`
        $this->addForeignKey(
            'fk_trade_proposal_trade_id',
            '{{%trade_proposal}}',
            'trade_id',
            '{{%trade}}',
            'id',
            'CASCADE'
        );

        // Table `cart`
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_info_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull(),
        ]);

        // Foreign key for `cart`
        $this->addForeignKey(
            'fk_cart_user_info_id',
            '{{%cart}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );


        $this->addPrimaryKey('pk_cart_item', '{{%cart_item}}', ['cart_id', 'trade_proposal_id']);

        // Foreign keys for `cart_item`
        $this->addForeignKey(
            'fk_cart_item_cart_id',
            '{{%cart_item}}',
            'cart_id',
            '{{%cart}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_cart_item_trade_proposal_id',
            '{{%cart_item}}',
            'trade_proposal_id',
            '{{%trade_proposal}}',
            'id',
            'CASCADE'
        );


        $this->addPrimaryKey('pk_saved_advertisement', '{{%saved_advertisement}}', ['user_info_id', 'advertisement_id']);

        // Foreign keys for `saved_advertisement`
        $this->addForeignKey(
            'fk_saved_advertisement_user_info_id',
            '{{%saved_advertisement}}',
            'user_info_id',
            '{{%user_info}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_saved_advertisement_advertisement_id',
            '{{%saved_advertisement}}',
            'advertisement_id',
            '{{%advertisement}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop tables in reverse order to satisfy foreign key dependencies
        $this->dropTable('{{%saved_advertisement}}');
        $this->dropTable('{{%cart_item}}');
        $this->dropTable('{{%cart}}');
        $this->dropTable('{{%trade_proposal}}');
        $this->dropTable('{{%report}}');
        $this->dropTable('{{%review}}');
        $this->dropTable('{{%item}}');
        $this->dropTable('{{%trade_proposal_item}}');
        $this->dropTable('{{%trade}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%advertisement}}');
        $this->dropTable('{{%user_info}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_221142_database_inicial cannot be reverted.\n";

        return false;
    }
    */
}
