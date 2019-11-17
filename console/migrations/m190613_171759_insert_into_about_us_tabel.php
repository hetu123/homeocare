<?php

use yii\db\Migration;

/**
 * Class m190613_171759_insert_into_about_us_tabel
 */
class m190613_171759_insert_into_about_us_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('about_us',array(
            'description'=>'Dr. Jatin and Dr. Dhwanika are enthusiastic and dynamic couple. They are serving humanity since many years. They have completed their Post graduate M.D degree .And are attached with academics being a reader and a lecturer in the Postgraduate as well as Undergraduate department in the college at Anand as well as Ahmedabad district in Gujarat. They are also regularly organizing free Homoeopathic Checkup and treatment camps at their clinics. They are also providing free service at various rural centers. Along with this they also serve people through their Homoeopathic clinics at Ahmedabad as well as at Nadiad in Gujarat. Various scientific research papers have been presented by them. Renal Stones and their successful treatment with Homoeopathic medicines is the field of their work. They have treated more then 100 cases of renal calculi successfully. An individual remains free from painful and costly operative procedure.',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_171759_insert_into_about_us_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_171759_insert_into_about_us_tabel cannot be reverted.\n";

        return false;
    }
    */
}
