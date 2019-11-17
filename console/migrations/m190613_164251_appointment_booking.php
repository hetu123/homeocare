<?php

use yii\db\Migration;

/**
 * Class m190613_164251_appointment_booking
 */
class m190613_164251_appointment_booking extends Migration
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
        $this->createTable('{{%appoinment_booking}}', [
            'id'=> $this->primaryKey(),
            'age_group_id'=>$this->integer(11)->notNull(),
            'date' => $this->date(),
            'time_slot_id'=> $this->integer(11)->notNull(),
            'symptoms'=> $this->string(255),
            'id_Approved' => $this->smallInteger()->notNull()->defaultValue(0),
            'id_Canceled' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->string(255),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
          ], $tableOptions);
          $this->createIndex(
            'idx-appoinment_booking-age_group_id',
            'appoinment_booking',
            'age_group_id'
        );
  
        $this->addForeignKey(
            'fk_appoinment_booking-age_group_id',
            'appoinment_booking',
            'age_group_id',
            'age_group',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            'idx-appoinment_booking-time_slot_id',
            'appoinment_booking',
            'time_slot_id'
        );
  
        $this->addForeignKey(
            'fk_appoinment_booking-time_slot_id',
            'appoinment_booking',
            'time_slot_id',
            'time_slot',
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
            'idx-appoinment_booking-age_group_id',
            'appoinment_booking'
        );

        $this->dropIndex(
            'fk_appoinment_booking-age_group_id',
            'appoinment_booking'
        );
        $this->dropForeignKey(
            'idx-appoinment_booking-time_slot_id',
            'appoinment_booking'
        );
        $this->dropForeignKey(
            'fk_appoinment_booking-time_slot_id',
            'appoinment_booking'
        );
        $this->dropTable('appoinment_booking');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_164251_appointment_booking cannot be reverted.\n";

        return false;
    }
    */
}
