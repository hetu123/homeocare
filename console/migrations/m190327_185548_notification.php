<?php

use yii\db\Migration;

/**
 * Class m190327_185548_notification
 */
class m190327_185548_notification extends Migration
{
    var $tableName = 'notification';
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

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'from_id' => $this->integer()->notNull(),
            'to_id' => $this->integer()->notNull(),
            'reference_id' => $this->integer()->notNull()->defaultValue(NULL),
            'fk_device_id' => $this->integer()->notNull(),
            'type' => "ENUM('Follow Request', 'Request to join group','Invite to join group','Accept group request','Reject group Request','Group post','Post comment','Rank changed','Position changed','Reject Group Invitation','Accept Group Invitation','MESSAGE')",
            'message' => $this->string(1000),
            'json_data' => $this->string(1000)->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
        $this->createIndex(
            'idx_notification-from_id',
            'notification',
            'from_id'
        );

        $this->addForeignKey(
            'fk_notification-from_id',
            'notification',
            'from_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            'idx_notification-to_id',
            'notification',
            'to_id'
        );

        $this->addForeignKey(
            'fk_notification-to_id',
            'notification',
            'to_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        list($foreignKey, $toTableName, $toColumn) = ['fk_device_id', 'apns_devices', 'id'];
        $this->createIndex('idx-' . $this->tableName . '-' . $foreignKey, $this->tableName, $foreignKey);

        //  foreignkey-name, tablename, colum-name, to-tablename, to-column
        $this->addForeignKey(
            'fk-' . $this->tableName . '-' . $foreignKey,
            $this->tableName,
            $foreignKey,
            $toTableName,
            $toColumn,
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropIndex(
            'idx_notification-from_id',
            'notification'
        );
        $this->dropForeignKey(
            'fk_notification-from_id',
            'notification'
        );
        $this->dropIndex(
            'idx_notification-to_id',
            'notification'
        );
        $this->dropForeignKey(
            'fk_notification-to_id',
            'notification'
        );
        $this->dropTable('{{%notification}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_185548_notification cannot be reverted.\n";

        return false;
    }
    */
}
