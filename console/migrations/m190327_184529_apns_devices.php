<?php

use yii\db\Migration;

/**
 * Class m190327_184529_apns_devices
 */
class m190327_184529_apns_devices extends Migration
{
    /**
     * {@inheritdoc}
     */
    var $tableName = 'apns_devices';

    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'device_uuid' => $this->string(64)->notNull(),
            'device_token' => $this->string()->notNull(),
            'platform_type' => 'ENUM("ios", "android", "other") NOT NULL DEFAULT "other"',
            'app_name' => $this->string(50),
            'app_version' => $this->string(10),
            'device_name' => $this->string(50),
            'device_model' => $this->string(50),
            'device_os_version' => $this->string(10),
            'push_badge' => 'ENUM("disable", "enable") DEFAULT NULL',
            'push_alert' => 'ENUM("disable", "enable") DEFAULT NULL',
            'push_sound' => 'ENUM("disable", "enable") DEFAULT NULL',
            'environment' => 'ENUM("development", "production") DEFAULT "production"',
            'status' => 'ENUM("active", "uninstalled") DEFAULT "active"',

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);


        //  foreignkey-name, tablename, colum-name, to-tablename, to-column
        list($foreignKey, $toTableName, $toColumn) = ['user_id', 'user', 'id'];
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

        //drops foreign key for table `$tablename`
        $foreignKey = 'user_id';
        $this->dropForeignKey(
            'fk-' . $this->tableName . '-' . $foreignKey,
            $this->tableName
        );

        $this->dropIndex(
            'idx-' . $this->tableName . '-' . $foreignKey,
            $this->tableName
        );

        $this->dropTable('{{%apns_devices}}');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_184529_apns_devices cannot be reverted.\n";

        return false;
    }
    */
}
