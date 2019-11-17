<?php

use yii\db\Migration;

/**
 * Class m190328_162925_blog
 */
class m190328_162925_blog extends Migration
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

        $this->createTable('{{%blogs}}', [
            'id' => $this->primaryKey(),
            'language_id'=> $this->integer(),
            'title'=>$this->string(255),
            'slug'=>$this->string(255)->notNull(),
            'description'=>$this->text(),
            'excerpt'=>$this->text(),
            'offer_url' => $this->string(255),
            'thumbnail'=>$this->string(255),
            'blogs'=>$this->string(255),
            'is_featured'=>$this->integer(1)->notNull(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'=> 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',

        ], $tableOptions);
        $this->createIndex(
            'idx-blogs-language_id',
            'blogs',
            'language_id'
        );

        $this->addForeignKey(
            'fk_blogs-language_id',
            'blogs',
            'language_id',
            'language',
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
            'idx-blogs-language_id',
            'blogs'
        );
        $this->dropForeignKey(
            'fk_blogs-language_id',
            'blogs'
        );
        $this->dropTable('blogs');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_162925_blog cannot be reverted.\n";

        return false;
    }
    */
}
