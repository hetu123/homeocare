<?php

use yii\db\Migration;

/**
 * Class m190327_183824_medicine_image
 */
class m190327_183824_medicine_image extends Migration
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
        $this->createTable('{{%medicine_image}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'image' => $this->string(),
            'image_dimension' => $this->string(),
            'is_cover' => $this->boolean(),
            'position' => $this->integer(),
            'visible' => $this->boolean(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-medicine_image-medicine_id',
            'medicine_image',
            'medicine_id'
        );



        $this->addForeignKey(
            'fk_medicine_image-medicine_id',
            'medicine_image',
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
            'idx-medicine_image-medicine_id',
            'medicine_image'
        );


        $this->dropForeignKey(
            'fk_medicine_image-medicine_id',
            'medicine_image'
        );

        $this->dropTable('medicine_image');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_183824_medicine_image cannot be reverted.\n";

        return false;
    }
    */
}
