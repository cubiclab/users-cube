<?php
/**
 * Created by PhpStorm.
 * User: Pt1c
 * Date: 14.11.2015
 * Time: 20:16
 */

use yii\db\Schema;
use yii\db\Migration;

class m200809_121519_init_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_token}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' null',
            'type' => Schema::TYPE_SMALLINT . ' not null',
            'token' => Schema::TYPE_STRING . ' not null',
            'data' => Schema::TYPE_STRING . ' null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'expired_at' => Schema::TYPE_TIMESTAMP . ' null',
        ], $tableOptions);

        // Indexes
        $this->createIndex('username', '{{%users}}', 'username', true);
        $this->createIndex('email', '{{%users}}', 'email', true);
        $this->createIndex('status', '{{%users}}', 'status');
        $this->createIndex('created_at', '{{%users}}', 'created_at');

    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_profile_user', '{{%users_profiles}}');

        $this->dropTable('{{%users_profiles}}');
        $this->dropTable('{{%users}}');
    }

}
