<?php

use yii\db\Migration;

/**
 * Class m190327_181059_packing
 */
class m190327_181059_packing extends Migration
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
        $this->createTable('{{%packing}}', [
            'id'=> $this->primaryKey(),
            'language_id'=> $this->integer(),
            'weight_type'=> $this->string(20)->notNull(),
            'weight'=> $this->integer(11),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-packing-language_id',
            'packing',
            'language_id'
        );

        $this->addForeignKey(
            'fk_packing-language_id',
            'packing',
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
            'idx-packing-language_id',
            'packing'
        );
        $this->dropForeignKey(
            'fk_packing-language_id',
            'packing'
        );
        $this->dropTable('{{%packing}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_181059_packing cannot be reverted.\n";

        return false;
    }
    */
}
