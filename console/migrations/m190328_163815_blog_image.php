<?php

use yii\db\Migration;

/**
 * Class m190328_163815_blog_image
 */
class m190328_163815_blog_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%blog_image}}', [
            'id'=> $this->primaryKey(),
            'medicine_id'=>$this->integer(11)->notNull(),
            'image_id'=>$this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-blog_image-medicine_id',
            'blog_image',
            'medicine_id'
        );

        $this->createIndex(
            'idx-blog_image-image_id',
            'blog_image',
            'image_id'
        );

        $this->addForeignKey(
            'fk_blog_image-medicine_id',
            'blog_image',
            'medicine_id',
            'medicines',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_blog_image-image_id',
            'blog_image',
            'image_id',
            'image',
            'id',
            'CASCADE',
            'CASCADE'
        );*/

    }

    /**
     * {@inheritdoc}
     */

    public function safeDown()
    {
       /* $this->dropIndex(
            'idx-blog_image-medicine_id',
            'blog_image'
        );

        $this->dropIndex(
            'idx-blog_image-image_id',
            'blog_image'
        );
        $this->dropForeignKey(
            'fk_blog_image-medicine_id',
            'blog_image'
        );
        $this->dropForeignKey(
            'fk_blog_image-image_id',
            'blog_image'
        );
        $this->dropTable('blog_image');*/
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_163815_blog_image cannot be reverted.\n";

        return false;
    }
    */
}
