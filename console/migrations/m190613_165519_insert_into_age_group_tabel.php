<?php

use yii\db\Migration;

/**
 * Class m190613_165519_insert_into_age_group_tabel
 */
class m190613_165519_insert_into_age_group_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('age_group',array(
            'age_group'=>'1-10',
        ));
        $this->insert('age_group',array(
            'age_group'=>'10-20',
        ));
        $this->insert('age_group',array(
            'age_group'=>'20-30',
        ));
        $this->insert('age_group',array(
            'age_group'=>'30-40',
        ));
        $this->insert('age_group',array(
            'age_group'=>'40-50',
        ));
        $this->insert('age_group',array(
            'age_group'=>'50-60',
        ));
        $this->insert('age_group',array(
            'age_group'=>'70-80',
        ));
        $this->insert('age_group',array(
            'age_group'=>'80-90',
        ));
        $this->insert('age_group',array(
            'age_group'=>'90-100',
        ));
        $this->insert('age_group',array(
            'age_group'=>'100-110',
        ));
        $this->insert('age_group',array(
            'age_group'=>'110-120',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_165519_insert_into_age_group_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_165519_insert_into_age_group_tabel cannot be reverted.\n";

        return false;
    }
    */
}
