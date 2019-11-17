<?php

use yii\db\Migration;

/**
 * Class m190327_175902_ingredients
 */
class m190327_175902_ingredients extends Migration
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
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'language_id'=> $this->integer(),
            'name' => $this->string(255)->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-ingredients-language_id',
            'ingredients',
            'language_id'
        );

        $this->addForeignKey(
            'fk_ingredients-language_id',
            'ingredients',
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
            'idx-ingredients-language_id',
            'ingredients'
        );
        $this->dropForeignKey(
            'fk_ingredients-language_id',
            'ingredients'
        );
        $this->dropTable('{{%ingredients}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_175902_ingredients cannot be reverted.\n";

        return false;
    }
    */
}
