<?php

use yii\db\Migration;

/**
 * Class m190429_161540_medicine_master
 */
class m190429_161540_medicine_master extends Migration
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
        $this->createTable('{{%medicine_master}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_master-medicine_id',
            'medicine_master',
            'medicine_id'
        );



        $this->addForeignKey(
            'fk_medicine_master-medicine_id',
            'medicine_master',
            'medicine_id',
            'medicines',
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
            'idx-medicine_master-medicine_id',
            'medicine_master'
        );


        $this->dropForeignKey(
            'fk_medicine_master-medicine_id',
            'medicine_master'
        );

        $this->dropTable('medicine_master');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190429_161540_medicine_master cannot be reverted.\n";

        return false;
    }
    */
}
