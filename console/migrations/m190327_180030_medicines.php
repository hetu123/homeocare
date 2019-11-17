<?php

use yii\db\Migration;

/**
 * Class m190327_180030_medicines
 */
class m190327_180030_medicines extends Migration
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
        $this->createTable('{{%medicines}}', [
            'id'=> $this->primaryKey(),
            'language_id'=> $this->integer(),
            'code'=>$this->string()->defaultValue(Null),
            'name'=> $this->string(255)->notNull(),
            'gujrati_name'=> $this->string(255),
            'hindi_name'=> $this->string(255),
            'description'=>$this->text(),
            'gujrati_description'=>$this->text(),
            'hindi_description'=>$this->text(),
            'dosages'=>$this->text(),
            'solution_for'=>$this->text(),
            'direction'=>$this->text(),
            'indications'=>$this->text(),
            'tags'=>$this->text(),
            'gujrati_tags'=>$this->text(),
            'hindi_tags'=>$this->text(),
            'total_stock'=>$this->integer(),
            'total_gst' => $this->integer(),
            'MRP'=> $this->integer()->notNull(),
            'use_stock'=>$this->integer(),
            'left_stock'=>$this->integer(),
            'is_active'=> $this->boolean()->defaultValue(1),
            'manufacture_date'=>$this->date(),
            'expiry_date'=>$this->date(),
            'price'=> $this->float()->notNull()->defaultValue(0.0),
            'discount_in_amount'=> $this->float()->notNull()->defaultValue(0.0),
            'discount_in_percentage'=> $this->float()->notNull()->defaultValue(0.0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex(
            'idx-medicines-language_id',
            'medicines',
            'language_id'
        );

        $this->addForeignKey(
            'fk_medicines-language_id',
            'medicines',
            'language_id',
            'language',
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
            'idx-medicines-language_id',
            'medicines'
        );
        $this->dropForeignKey(
            'fk_medicines-language_id',
            'medicines'
        );
        $this->dropTable('{{%medicines}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_180030_medicines cannot be reverted.\n";

        return false;
    }
    */
}
