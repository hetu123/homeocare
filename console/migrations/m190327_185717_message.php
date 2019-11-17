<?php

use yii\db\Migration;

/**
 * Class m190327_185717_message
 */
class m190327_185717_message extends Migration
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

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'from_id' => $this->integer()->notNull(),
            'to_id' => $this->integer()->notNull(),
            'message' => $this->string(),
            'is_read' => $this->boolean()->defaultValue(0),
            'deletedBy'=>$this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx_message-from_id',
            'message',
            'from_id'
        );

        $this->addForeignKey(
            'fk_message-from_id',
            'message',
            'from_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            'idx_message-to_id',
            'message',
            'to_id'
        );

        $this->addForeignKey(
            'fk_message-to_id',
            'message',
            'to_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropIndex(
            'idx_message-from_id',
            'message'
        );
        $this->dropForeignKey(
            'fk_message-from_id',
            'message'
        );
        $this->dropIndex(
            'idx_message-to_id',
            'message'
        );
        $this->dropForeignKey(
            'fk_message-to_id',
            'message'
        );
        $this->dropTable('{{%message}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_185717_message cannot be reverted.\n";

        return false;
    }
    */
}
