<?php

use yii\db\Migration;

/**
 * Class m190327_183532_medicine_composition
 */
class m190327_183532_medicine_composition extends Migration
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
        $this->createTable('{{%medicine_composition}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'composition_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_composition-medicine_id',
            'medicine_composition',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_composition-composition_id',
            'medicine_composition',
            'composition_id'
        );

        $this->addForeignKey(
            'fk_medicine_composition-medicine_id',
            'medicine_composition',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_composition-composition_id',
            'medicine_composition',
            'composition_id',
            'composition',
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
            'idx-medicine_composition-medicine_id',
            'medicine_composition'
        );

        $this->dropIndex(
            'idx-medicine_composition-composition_id',
            'medicine_composition'
        );
        $this->dropForeignKey(
            'fk_medicine_composition-medicine_id',
            'medicine_composition'
        );
        $this->dropForeignKey(
            'fk_medicine_composition-composition_id',
            'medicine_composition'
        );
        $this->dropTable('medicine_composition');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_183532_medicine_composition cannot be reverted.\n";

        return false;
    }
    */
}
