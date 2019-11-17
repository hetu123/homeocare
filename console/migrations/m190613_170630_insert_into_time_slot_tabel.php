<?php

use yii\db\Migration;

/**
 * Class m190613_170630_insert_into_time_slot_tabel
 */
class m190613_170630_insert_into_time_slot_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('time_slot',array(
            'day'=>'Monday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
        $this->insert('time_slot',array(
            'day'=>'Tuesday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
        $this->insert('time_slot',array(
            'day'=>'Wednesday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
        $this->insert('time_slot',array(
            'day'=>'Thursday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
        $this->insert('time_slot',array(
            'day'=>'Friday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
        $this->insert('time_slot',array(
            'day'=>'Saturday',
            'morning_hours_from' =>'9.30 A.M.',
            'morning_hours_to' =>'12.30 A.M.',
            'evening_hours_from' =>'5.30 P.M.',
            'evening_hours_to' => '8.30 P.M.',
            'is_open'=> '1',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_170630_insert_into_time_slot_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_170630_insert_into_time_slot_tabel cannot be reverted.\n";

        return false;
    }
    */
}
