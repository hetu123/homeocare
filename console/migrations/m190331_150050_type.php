<?php

use yii\db\Migration;

/**
 * Class m190331_150050_type
 */
class m190331_150050_type extends Migration
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
        $this->createTable('{{%type}}', [
            'id'=> $this->primaryKey(),
            'language_id'=> $this->integer(),
            'type'=> $this->string(255)->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-type-language_id',
            'type',
            'language_id'
        );

        $this->addForeignKey(
            'fk_type-language_id',
            'type',
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
            'idx-type-language_id',
            'type'
        );
        $this->dropForeignKey(
            'fk_type-language_id',
            'type'
        );
        $this->dropTable('type');
        $this->dropTable('{{%type}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190331_150050_type cannot be reverted.\n";

        return false;
    }
    */
}
