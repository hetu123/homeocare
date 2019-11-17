<?php

use yii\db\Migration;

/**
 * Class m190327_184324_medicine_category
 */
class m190327_184324_medicine_category extends Migration
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
        $this->createTable('{{%medicine_category}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'category_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_category-medicine_id',
            'medicine_category',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_category-category_id',
            'medicine_category',
            'category_id'
        );

        $this->addForeignKey(
            'fk_medicine_category-medicine_id',
            'medicine_category',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_category-category_id',
            'medicine_category',
            'category_id',
            'category',
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
            'idx-medicine_category-medicine_id',
            'medicine_category'
        );

        $this->dropIndex(
            'idx-medicine_category-category_id',
            'medicine_category'
        );
        $this->dropForeignKey(
            'fk_medicine_category-medicine_id',
            'medicine_category'
        );
        $this->dropForeignKey(
            'fk_medicine_category-category_id',
            'medicine_category'
        );
        $this->dropTable('medicine_category');
    }


    /*/
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_184324_medicine_category cannot be reverted.\n";

        return false;
    }
    */
}
