<?php

use yii\db\Migration;

/**
 * Class m190524_154355_customer_address
 */
class m190524_154355_customer_address extends Migration
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
        $this->createTable('{{%user_address}}', [
            'id'=> $this->primaryKey(),
            'user_id'=>$this->integer(11)->notNull(),
            'address_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-user_address-user_id',
            'user_address',
            'user_id'
        );

        $this->createIndex(
            'idx-user_address-address_id',
            'user_address',
            'address_id'
        );

        $this->addForeignKey(
            'fk_user_address-user_id',
            'user_address',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_address-address_id',
            'user_address',
            'address_id',
            'addresses',
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
            'idx-user_address-user_id',
            'user_address'
        );

        $this->dropIndex(
            'idx-user_address-address_id',
            'user_address'
        );
        $this->dropForeignKey(
            'fk_user_address-user_id',
            'user_address'
        );
        $this->dropForeignKey(
            'fk_user_address-address_id',
            'user_address'
        );
        $this->dropTable('user_address');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_154355_customer_address cannot be reverted.\n";

        return false;
    }
    */
}
