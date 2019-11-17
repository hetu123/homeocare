<?php

use yii\db\Migration;

/**
 * Class m190418_101802_medicines_conditions
 */
class m190418_101802_medicines_conditions extends Migration
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
        $this->createTable('{{%medicine_conditions}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'condition_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_conditions-medicine_id',
            'medicine_conditions',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_conditions-condition_id',
            'medicine_conditions',
            'condition_id'
        );

        $this->addForeignKey(
            'fk_medicine_conditions-medicine_id',
            'medicine_conditions',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_conditions-condition_id',
            'medicine_conditions',
            'condition_id',
            'conditions',
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
            'idx-medicine_conditions-medicine_id',
            'medicine_conditions'
        );

        $this->dropIndex(
            'idx-medicine_conditions-condition_id',
            'medicine_conditions'
        );
        $this->dropForeignKey(
            'fk_medicine_composition-medicine_id',
            'medicine_conditions'
        );
        $this->dropForeignKey(
            'fk_medicine_composition-condition_id',
            'medicine_conditions'
        );
        $this->dropTable('medicine_conditions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190418_101802_medicines_conditions cannot be reverted.\n";

        return false;
    }
    */
}
