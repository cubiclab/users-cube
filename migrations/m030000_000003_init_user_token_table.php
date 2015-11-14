<?php
/**
 * Created by PhpStorm.
 * User: Pt1c
 * Date: 14.11.2015
 * Time: 20:16
 */

use yii\db\Migration;

class m030000_000003_init_user_token_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users_token}}', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'type'          => $this->smallInteger()->notNull(),
            'token'         => $this->string()->notNull(),
            'data'          => $this->string(),
            'created_at'    => $this->integer(),
            'expired_at'    => $this->integer(),
        ], $tableOptions);

        //Indexes
        $this->createIndex('{{%users_token_token}}', '{{%users_token}}', 'token', true);

        //Foreign Keys
        $this->addForeignKey('FK_users_token_users', '{{%users_token}}', 'user_id', '{{%users}}', 'id');

    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_users_token_users', '{{%users_token}}');
        $this->dropTable('{{%users_token}}');
    }

}
