<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(20)->notNull()->unique(),
            'fullname'=>$this->string(),
            //'lastname' =>$this->string(20),
            'gender'=>"ENUM('f', 'm') ",
            'email' => $this->string(255)->unique(),
            'address'=>$this->string(255),
            'phonenumber'=>$this->string(25)->unique(),
            'auth_key' => $this->string(255)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->unique(),
            'otp'=> $this->string(255)->defaultValue(Null),
            'otp_expire'=> $this->integer()->defaultValue(Null),
            'profile_pic'=>$this->string(255),
            'google_id'=>$this->string(255),
            'facebook_id'=>$this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
/*            'role'=>"ENUM('super admin','admin', 'user') DEFAULT 'user' ",*/
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
