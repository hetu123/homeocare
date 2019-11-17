<?php

use yii\db\Migration;

/**
 * Class m190331_150242_medicine_type
 */
class m190331_150242_medicine_type extends Migration
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
        $this->createTable('{{%medicine_type}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'type_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_type-medicine_id',
            'medicine_type',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_type-type_id',
            'medicine_type',
            'type_id'
        );

        $this->addForeignKey(
            'fk_medicine_type-medicine_id',
            'medicine_type',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_type-type_id',
            'medicine_type',
            'type_id',
            'type',
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
            'idx-medicine_type-medicine_id',
            'medicine_type'
        );

        $this->dropIndex(
            'idx-medicine_type-type_id',
            'medicine_type'
        );
        $this->dropForeignKey(
            'fk_medicine_type-medicine_id',
            'medicine_type'
        );
        $this->dropForeignKey(
            'fk_medicine_type-type_id',
            'medicine_type'
        );
        $this->dropTable('medicine_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190331_150242_medicine_type cannot be reverted.\n";

        return false;
    }
    */
}
