<?php

use yii\db\Schema;
use yii\db\Migration;

class m200809_121518_init_default_rbac extends Migration
{
    public $sqls = [];

    public function safeUp()
    {
        //add default permissions
        $permissions = [
            'ACPAccessDashboard' => 'Can access to ACP',
            'ACPUsersView' => 'Can View Users',
            'ACPUsersCreate' => 'Can Create Users',
            'ACPUsersUpdate' => 'Can Update Users',
            'ACPUsersDelete' => 'Can Delete Users',
        ];
        foreach ($permissions as $permission => $description) {
            $permit = Yii::$app->authManager->createPermission($permission);
            $permit->description = $description;
            Yii::$app->authManager->add($permit);
        }


        //add default roles
        $roles = [
            'RootAdmin' => 'Can access to ACP',
            'Admin' => 'Can View Users',
            'Moderator' => 'Can Create Users',
            'User' => 'Can Update Users',
        ];
        foreach ($roles as $role => $description) {
            $role = Yii::$app->authManager->createRole($role);
            $role->description = $description;
            Yii::$app->authManager->add($role);
        }


        //set permissions to roles
        $roles_permissions = [
            'RootAdmin' => ['ACPAccessDashboard', 'ACPUsersView', 'ACPUsersCreate', 'ACPUsersUpdate', 'ACPUsersDelete']
        ];
        foreach ($roles_permissions as $role => $permissions) {
            foreach ($permissions as $permit) {
                Yii::$app->authManager->addChild(Yii::$app->authManager->getRole($role), Yii::$app->authManager->getPermission($permit));
            }
        }


        $time = time();
        // add role to root user (id =1)
        $this->sqls[] = "INSERT INTO {{%auth_assignment}} (item_name, user_id, created_at)
                                                   VALUES ('RootAdmin', 1, $time)";

        // execute all sqls
        foreach ($this->sqls as $sql) {
            $this->execute($sql);
        }
    }

    public function safeDown()
    {

    }

}
