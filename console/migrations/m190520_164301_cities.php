<?php

use yii\db\Migration;

/**
 * Class m190520_164301_cities
 */
class m190520_164301_cities extends Migration
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
      $this->createTable('{{%cities}}', [
          'id'=> $this->primaryKey(),
          'state_id'=> $this->integer(),
          'name'=> $this->string(255)->notNull(),
          'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
          'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
      ], $tableOptions);
      $this->createIndex(
          'idx-cities-state_id',
          'cities',
          'state_id'
      );

      $this->addForeignKey(
          'fk_cities-state_id',
          'cities',
          'state_id',
          'states',
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
        'idx-cities-state_id',
        'cities'
      );
      $this->dropForeignKey(
        'fk_cities-state_id',
        'cities'
      );
      $this->dropTable('cities');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_164301_cities cannot be reverted.\n";

        return false;
    }
    */
}
