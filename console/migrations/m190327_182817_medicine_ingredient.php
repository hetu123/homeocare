<?php

use yii\db\Migration;

/**
 * Class m190327_182817_medicine_ingredient
 */
class m190327_182817_medicine_ingredient extends Migration
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
        $this->createTable('{{%medicine_ingredient}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'ingredient_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_ingredient-medicine_id',
            'medicine_ingredient',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_ingredient-ingredient_id',
            'medicine_ingredient',
            'ingredient_id'
        );

        $this->addForeignKey(
            'fk_medicine_ingredient-medicine_id',
            'medicine_ingredient',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_ingredient-ingredient_id',
            'medicine_ingredient',
            'ingredient_id',
            'ingredients',
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
            'idx-medicine_ingredient-medicine_id',
            'medicine_ingredient'
        );

        $this->dropIndex(
            'idx-medicine_ingredient-ingredient_id',
            'medicine_ingredient'
        );
        $this->dropForeignKey(
            'fk_medicine_ingredient-medicine_id',
            'medicine_ingredient'
        );
        $this->dropForeignKey(
            'fk_medicine_ingredient-ingredient_id',
            'medicine_ingredient'
        );
        $this->dropTable('medicine_ingredient');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_182817_medicine_ingredient cannot be reverted.\n";

        return false;
    }
    */
}
