<?php

use yii\db\Migration;

/**
 * Class m190327_175141_category
 */
class m190327_175141_category extends Migration
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

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'language_id'=> $this->integer(),
            'pid' =>  $this->integer(11)->defaultValue(0    ),
            'name' => $this->string(255)->notNull(),
            'description'=>$this->text(),
            'image'=>$this->string(255),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-category-language_id',
            'category',
            'language_id'
        );

        $this->addForeignKey(
            'fk_category-language_id',
            'category',
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
            'idx-category-language_id',
            'category'
        );
        $this->dropForeignKey(
            'fk_category-language_id',
            'category'
        );
        $this->dropTable('{{%category}}');
    }
}
