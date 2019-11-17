<?php

use yii\db\Migration;

/**
 * Class m190615_175712_insert_into_language
 */
class m190615_175712_insert_into_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('language',array(
            'name'=>'English',
            'code'=>'EN',
            'is_active'=> '1'
        ));

        $this->insert('language',array(
            'name'=>'Gujrati',
            'code'=>'GU',
            'is_active'=> '1'
        ));

        $this->insert('language',array(
            'name'=>'Hindi',
            'code'=>'HN',
            'is_active'=> '1'
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190615_175712_insert_into_language cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190615_175712_insert_into_language cannot be reverted.\n";

        return false;
    }
    */
}
