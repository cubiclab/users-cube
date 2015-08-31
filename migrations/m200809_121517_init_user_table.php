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
            'avatar'        => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
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
        $this->createTable('{{%users_profiles}}', [
            'user_id'       => Schema::TYPE_PK,
            'first_name'    => Schema::TYPE_STRING . '(50) NULL DEFAULT NULL',
            'surname'       => Schema::TYPE_STRING . '(50) NULL DEFAULT NULL',
            'patronymic'    => Schema::TYPE_STRING . '(50) NULL DEFAULT NULL',
            'birth_date'    => Schema::TYPE_DATE . ' NULL DEFAULT NULL',
            'gender'        => Schema::TYPE_SMALLINT . ' NULL DEFAULT NULL',
            'phone'         => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'address'       => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'notes'         => Schema::TYPE_TEXT . ' NULL DEFAULT NULL',
        ], $tableOptions);

        // Foreign Keys
        $this->addForeignKey('FK_profile_user', '{{%users_profiles}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

        // Add root user
        $this->execute($this->createUserSql());
        $this->execute($this->createProfileSql());
    }

    /** @return string SQL to insert root user */
    private function createUserSql()
    {
        $time = time();
        $password_hash = Yii::$app->security->generatePasswordHash('root');
        $auth_key = Yii::$app->security->generateRandomString();
        return "INSERT INTO {{%users}} (id, username, password, email, auth_key, api_key, status, avatar, created_at, updated_at, created_by, updated_by)
                                VALUES (NULL, 'root', '$password_hash', 'root@cubiclab.ru', '$auth_key', '', 1, NULL , $time, $time, NULL, NULL)";
    }

    /** @return string SQL to insert first profile */
    private function createProfileSql()
    {
        // not realised yet
        return "INSERT INTO {{%users_profiles}} (user_id, first_name, surname, patronymic, birth_date, gender, phone, address, notes)
                                         VALUES (1, 'First Name', 'Second Name', 'Father Name', NULL, 0, NULL, NULL, NULL)";
    }


    public function safeDown()
    {
        $this->dropForeignKey('FK_profile_user', '{{%users_profiles}}');

        $this->dropTable('{{%users_profiles}}');
        $this->dropTable('{{%users}}');
    }

}
