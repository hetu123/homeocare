<?php

use yii\db\Migration;

/**
 * Class m190328_162347_cart
 */
class m190328_162347_cart extends Migration
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

        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'code'=>$this->string()->defaultValue(Null),
            'anonymous_identifier' =>$this->string(),
            'medicine_id'=>$this->integer(11),
            'store_price'=>$this->float()->notNull(),
            'discount'=>$this->integer(11),
            'quantity'=>$this->integer(11),
            'total_price'=>$this->float()->notNull(),
            'paid_price'=>$this->float()->notNull(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'=> 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createIndex(
            'idx_cart-medicine_id',
            'cart',
            'medicine_id'
        );

        $this->addForeignKey(
            'fk_cart-medicine_id',
            'cart',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            'idx_cart-user_id',
            'cart',
            'user_id'
        );

        $this->addForeignKey(
            'fk_cart-user_id',
            'cart',
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
            'idx_cart-medicine_id',
            'cart'
        );
        $this->dropForeignKey(
            'fk_cart-medicine_id',
            'cart'
        );
        $this->dropIndex(
            'idx_cart-user_id',
            'cart'
        );
        $this->dropForeignKey(
            'fk_cart-user_id',
            'cart'
        );
        $this->dropTable('{{%cart}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_162347_cart cannot be reverted.\n";

        return false;
    }
    */
}
