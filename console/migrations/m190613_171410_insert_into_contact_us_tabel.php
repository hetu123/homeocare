<?php

use yii\db\Migration;

/**
 * Class m190613_171410_insert_into_contact_us_tabel
 */
class m190613_171410_insert_into_contact_us_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('contact_us',array(
            'email'=>'support@domain.com',
            'location' =>'Nr.Crossing, Maninagar East Ahmedabad, Gujarat, India',
            'contact_number' =>'9426512506',
            'support_and_inquiries' =>'9426512506',
            'complains' => '9426512506',
            'tracking_and_delivery'=> '9426512506',
            'whats_app' =>' 942612506',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_171410_insert_into_contact_us_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_171410_insert_into_contact_us_tabel cannot be reverted.\n";

        return false;
    }
    */
}
