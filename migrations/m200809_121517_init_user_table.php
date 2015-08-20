<?php

use yii\db\Schema;
use yii\db\Migration;

class m200809_121517_init_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'            => Schema::TYPE_PK,
            'username'      => Schema::TYPE_STRING . ' null default null',
            'password'      => Schema::TYPE_STRING . ' null default null',
            'email'         => Schema::TYPE_STRING . ' null default null',
            'auth_key'      => Schema::TYPE_STRING . ' null default null',
            'api_key'       => Schema::TYPE_STRING . ' null default null',
            'status'        => Schema::TYPE_SMALLINT . ' not null',
            'login_ip'      => Schema::TYPE_STRING . ' null default null',
            'login_time'    => Schema::TYPE_INTEGER . ' null default null',
            'created_at'    => Schema::TYPE_INTEGER . ' null default null',
            'updated_at'    => Schema::TYPE_INTEGER . ' null default null',
            'created_by'    => Schema::TYPE_INTEGER . ' null default null',
            'updated_by'    => Schema::TYPE_INTEGER . ' null default null',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m150809_121517_init_user_table cannot be reverted.\n";

        $this->dropTable('{{%user}}');

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
