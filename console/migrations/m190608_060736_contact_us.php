<?php

use yii\db\Migration;

/**
 * Class m190608_060736_contact_us
 */
class m190608_060736_contact_us extends Migration
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
        $this->createTable('{{%contact_us}}', [
            'id'=> $this->primaryKey(),
            'email'=>$this->string(255),
            'location'=>$this->string(255),
            'contact_number'=>$this->string(),
            'support_and_inquiries'=>$this->string(),
            'complains'=>$this->string(),
            'tracking_and_delivery'=>$this->string(),
            'whats_app'=>$this->string(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
          ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('contact_us');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190608_060736_contact_us cannot be reverted.\n";

        return false;
    }
    */
}
