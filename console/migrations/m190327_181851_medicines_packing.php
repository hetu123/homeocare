<?php

use yii\db\Migration;

/**
 * Class m190327_181851_medicines_packing
 */
class m190327_181851_medicines_packing extends Migration
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
        $this->createTable('{{%medicine_packing}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'packing_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_packing-medicine_id',
            'medicine_packing',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_packing-packing_id',
            'medicine_packing',
            'packing_id'
        );

        $this->addForeignKey(
            'fk_medicine_packing-medicine_id',
            'medicine_packing',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_packing-packing_id',
            'medicine_packing',
            'packing_id',
            'packing',
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
            'idx-medicine_packing-medicine_id',
            'medicine_packing'
        );

        $this->dropIndex(
            'idx-medicine_packing-packing_id',
            'medicine_packing'
        );
        $this->dropForeignKey(
            'fk_medicine_packing-medicine_id',
            'medicine_packing'
        );
        $this->dropForeignKey(
            'fk_medicine_packing-packing_id',
            'medicine_packing'
        );
        $this->dropTable('medicine_packing');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_181851_medicines_packing cannot be reverted.\n";

        return false;
    }
    */
}
