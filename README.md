## Users Cube ##

Users module based on php framework Yii2.
This repository is development package.

#### Installing using Composer####

With Composer installed, you can then install the Cube using the following command:

    composer require cubiclab/users-cube:"dev-master"

Add the following lines to your YII config:
```php
// app/config/web.php & app/config/console.php
return [
    'language' => 'en', // 'ru'
    'modules' => [
        'admin' => [
            'class' => 'yii\admincube\AdminCube',
         ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'cubiclab\users\models\User'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
```

Apply migrations:

    $ yii migrate --migrationPath=@yii/rbac/migrations/
    $ yii migrate --migrationPath=@cubiclab/admin/migrations/
    $ yii migrate --migrationPath=@cubiclab/users/migrations/
