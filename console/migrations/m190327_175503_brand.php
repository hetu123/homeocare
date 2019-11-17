<?php

use yii\db\Migration;

/**
 * Class m190327_175503_brand
 */
class m190327_175503_brand extends Migration
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
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'language_id'=> $this->integer(),
            'name' => $this->string(255)->notNull(),
            'code'=>$this->string(255),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-brand-language_id',
            'brand',
            'language_id'
        );

        $this->addForeignKey(
            'fk_brand-language_id',
            'brand',
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
            'idx-brand-language_id',
            'brand'
        );
        $this->dropForeignKey(
            'fk_brand-language_id',
            'brand'
        );
        $this->dropTable('{{%brand}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_175503_brand cannot be reverted.\n";

        return false;
    }
    */
}
