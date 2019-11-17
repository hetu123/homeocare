<?php

use yii\db\Migration;

/**
 * Class m190613_154407_time_slots
 */
class m190613_154407_time_slots extends Migration
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
        $this->createTable('{{%time_slot}}', [
            'id'=> $this->primaryKey(),
            'day'=>$this->string(255),
            'morning_hours_from' => $this->string(255),
            'morning_hours_to'=> $this->string(255),
            'evening_hours_from' => $this->string(255),
            'evening_hours_to'=> $this->string(255),
            'is_open' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
          ], $tableOptions);

         
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('time_slot');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_154407_time_slots cannot be reverted.\n";

        return false;
    }
    */
}
