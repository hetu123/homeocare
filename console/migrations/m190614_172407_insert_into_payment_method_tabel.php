<?php

use yii\db\Migration;

/**
 * Class m190614_172407_insert_into_payment_method_tabel
 */
class m190614_172407_insert_into_payment_method_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('payment_methods',array(
            'name'=>'Case On Delivery',
            'code'=>'CA',
            'is_active'=> '1'
        ));

        $this->insert('payment_methods',array(
            'name'=>'Bank Draft',
            'code'=>'BD',
            'is_active'=> '1'
        ));

        $this->insert('payment_methods',array(
            'name'=>'Digital Payment',
            'code'=>'DP',
            'is_active'=> '1'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_172407_insert_into_payment_method_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_172407_insert_into_payment_method_tabel cannot be reverted.\n";

        return false;
    }
    */
}
