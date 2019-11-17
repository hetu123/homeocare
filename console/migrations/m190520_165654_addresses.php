<?php

use yii\db\Migration;

/**
 * Class m190520_165654_addresses
 */
class m190520_165654_addresses extends Migration
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
      $this->createTable('{{%addresses}}', [
          'id'=> $this->primaryKey(),
          'city_id'=> $this->integer(),
          'address1'=>$this->text(),
          'address2'=>$this->text(),
          'pincode'=> $this->string(255),
          'contact'=> $this->integer(13),
          'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
          'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
      ], $tableOptions);
      $this->createIndex(
          'idx-addresses-city_id',
          'addresses',
          'city_id'
      );

      $this->addForeignKey(
          'fk_addresses-city_id',
          'addresses',
          'city_id',
          'cities',
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
        'idx-addresses-city_id',
        'addresses'
      );
      $this->dropForeignKey(
        'fk_addresses-city_id',
        'addresses'
      );
      $this->dropTable('addresses');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_165654_addresses cannot be reverted.\n";

        return false;
    }
    */
}
