<?php

use yii\db\Migration;

/**
 * Class m190408_172935_conditions
 */
class m190408_172935_conditions extends Migration
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
        $this->createTable('{{%conditions}}', [
            'id'=> $this->primaryKey(),
            'language_id'=> $this->integer(),
            'condition'=> $this->string(255)->notNull(),
            'description'=>$this->text(),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-conditions-language_id',
            'conditions',
            'language_id'
        );

        $this->addForeignKey(
            'fk_conditions-language_id',
            'conditions',
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
            'idx-conditions-language_id',
            'conditions'
        );
        $this->dropForeignKey(
            'fk_conditions-language_id',
            'conditions'
        );
        $this->dropTable('{{%conditions}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190408_172935_conditions cannot be reverted.\n";

        return false;
    }
    */
}
