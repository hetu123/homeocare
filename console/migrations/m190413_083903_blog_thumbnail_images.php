<?php

use yii\db\Migration;

/**
 * Class m190413_083903_blog_thumbnail_images
 */
class m190413_083903_blog_thumbnail_images extends Migration
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
        $this->createTable('{{%blog_thumbnail_images}}', [
            'id'=> $this->primaryKey(),
            'blog_id'=>$this->integer(11)->notNull(),
            'image' => $this->string(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-blog_thumbnail_images-blog_id',
            'blog_thumbnail_images',
            'blog_id'
        );



        $this->addForeignKey(
            'fk_blog_thumbnail_images-blog_id',
            'blog_thumbnail_images',
            'blog_id',
            'blogs',
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
            'idx-blog_thumbnail_images-blog_id',
            'blog_thumbnail_images'
        );


        $this->dropForeignKey(
            'fk_blog_thumbnail_images-blog_id',
            'blog_thumbnail_images'
        );

        $this->dropTable('blog_thumbnail_images');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190413_083903_blog_thumbnail_images cannot be reverted.\n";

        return false;
    }
    */
}
