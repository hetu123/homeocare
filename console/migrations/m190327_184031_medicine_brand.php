<?php

use yii\db\Migration;

/**
 * Class m190327_184031_medicine_brand
 */
class m190327_184031_medicine_brand extends Migration
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
        $this->createTable('{{%medicine_brand}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'brand_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_brand-medicine_id',
            'medicine_brand',
            'medicine_id'
        );

        $this->createIndex(
            'idx-medicine_brand-brand_id',
            'medicine_brand',
            'brand_id'
        );

        $this->addForeignKey(
            'fk_medicine_brand-medicine_id',
            'medicine_brand',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_medicine_brand-brand_id',
            'medicine_brand',
            'brand_id',
            'brand',
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
            'idx-medicine_brand-medicine_id',
            'medicine_brand'
        );

        $this->dropIndex(
            'idx-medicine_brand-brand_id',
            'medicine_brand'
        );
        $this->dropForeignKey(
            'fk_medicine_brand-medicine_id',
            'medicine_brand'
        );
        $this->dropForeignKey(
            'fk_medicine_brand-brand_id',
            'medicine_brand'
        );
        $this->dropTable('medicine_brand');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_184031_medicine_brand cannot be reverted.\n";

        return false;
    }
    */
}
