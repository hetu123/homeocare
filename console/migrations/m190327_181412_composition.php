<?php

use yii\db\Migration;

/**
 * Class m190327_181412_composition
 */
class m190327_181412_composition extends Migration
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
        $this->createTable('{{%composition}}', [
            'id'=> $this->primaryKey(),
            'language_id'=> $this->integer(),
            'name' => $this->string(255)->notNull(),
            'weight_type'=> $this->string(255),
            'weight'=> $this->integer(11),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-composition-language_id',
            'composition',
            'language_id'
        );

        $this->addForeignKey(
            'fk_composition-language_id',
            'composition',
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
            'idx-composition-language_id',
            'composition'
        );
        $this->dropForeignKey(
            'fk_composition-language_id',
            'composition'
        );
        $this->dropTable('{{%composition}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_181412_composition cannot be reverted.\n";

        return false;
    }
    */
}
