<?php

use yii\db\Schema;
use yii\db\Migration;

class m200809_121517_init_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // Users table
        $this->createTable('{{%users}}', [
            'id'            => Schema::TYPE_PK,
            'username'      => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'password'      => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'email'         => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'auth_key'      => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'api_key'       => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'status'        => Schema::TYPE_SMALLINT . ' NOT NULL',
            'login_ip'      => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'login_time'    => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'created_at'    => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'updated_at'    => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'created_by'    => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'updated_by'    => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
        ], $tableOptions);

        // Indexes
        $this->createIndex('username', '{{%users}}', 'username', true);
        $this->createIndex('email', '{{%users}}', 'email', true);
        $this->createIndex('status', '{{%users}}', 'status');
        $this->createIndex('created_at', '{{%users}}', 'created_at');

        // Profiles table
        $this->createTable(
            '{{%users_profiles}}',
            [
                'user_id'   => Schema::TYPE_PK,
                'name'      => Schema::TYPE_STRING . '(50) NOT NULL',
                'surname'   => Schema::TYPE_STRING . '(50) NOT NULL',
                'phone'     => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
                'address'   => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            ],
            $tableOptions
        );

        // Foreign Keys
        $this->addForeignKey('FK_profile_user', '{{%users_profiles}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

        //TODO: Add a root user
    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_profile_user', '{{%users_profiles}}');

        $this->dropTable('{{%users_profiles}}');
        $this->dropTable('{{%users}}');
    }

}
