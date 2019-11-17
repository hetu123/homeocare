<?php

use yii\db\Migration;

/**
 * Class m190523_171700_wishlist
 */
class m190523_171700_wishlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%wishlist}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'anonymous_identifier' =>$this->string(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'=> 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createIndex(
            'idx_wishlist-medicine_id',
            'wishlist',
            'medicine_id'
        );

        $this->addForeignKey(
            'fk_wishlist-medicine_id',
            'wishlist',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx_wishlist-user_id',
            'wishlist',
            'user_id'
        );

        $this->addForeignKey(
            'fk_wishlist-user_id',
            'wishlist',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx_wishlist-medicine_id',
            'wishlist'
        );
        $this->dropForeignKey(
            'fk_wishlist-medicine_id',
            'wishlist'
        );
        $this->dropIndex(
            'idx_wishlist-user_id',
            'wishlist'
        );
        $this->dropForeignKey(
            'fk_wishlist-user_id',
            'wishlist'
        );
        $this->dropTable('{{%wishlist}}');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_171700_wishlist cannot be reverted.\n";

        return false;
    }
    */
}
