<?php

use yii\db\Migration;

/**
 * Class m190520_164223_countries
 */
class m190520_164223_countries extends Migration
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
      $this->createTable('{{%countries}}', [
          'id'=> $this->primaryKey(),
          'name'=> $this->string(255)->notNull(),
          'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
          'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
      ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('countries');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_164223_countries cannot be reverted.\n";

        return false;
    }
    */
}
