<?php

use yii\db\Migration;

/**
 * Class m190520_164236_states
 */
class m190520_164236_states extends Migration
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
      $this->createTable('{{%states}}', [
          'id'=> $this->primaryKey(),
          'country_id'=> $this->integer(),
          'name'=> $this->string(255)->notNull(),
          'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
          'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
      ], $tableOptions);
      $this->createIndex(
          'idx-states-country_id',
          'states',
          'country_id'
      );

      $this->addForeignKey(
          'fk_states-country_id',
          'states',
          'country_id',
          'countries',
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
        'idx-states-country_id',
        'states'
      );
      $this->dropForeignKey(
        'fk_states-country_id',
        'states'
      );
      $this->dropTable('states');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_164236_states cannot be reverted.\n";

        return false;
    }
    */
}
