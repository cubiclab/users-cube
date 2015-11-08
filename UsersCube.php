<?php
namespace cubiclab\users;

use Yii;
use cubiclab\base\BaseCube;

/**
 * @version 0.0.1-prealpha
 */
class UsersCube extends BaseCube
{
    /** @const VERSION Module version */
    const VERSION = "0.0.1-prealpha";

    /**
     * @inheritdoc
     */
    public static $name = 'users';

    /** @var boolean If true after registration user will be required to confirm his e-mail address. */
    public $requireEmailConfirmation = true;

    /** @var bool If true, users can log in using their email */
    public $loginEmail = true;

    /** @var bool If true, users can log in using their username */
    public $loginUsername = true;

    /** @var int Login duration */
    public $loginDuration = 2592000; //3600 * 24 * 30

    /**
     * @var array|string|null Url to redirect to after logging in. If null, will redirect to home page. Note that
     *                        AccessControl takes precedence over this (see [[yii\web\User::loginRequired()]])
     */
    public $loginRedirect = null;

    /**
     * @var array|string|null Url to redirect to after logging out. If null, will redirect to home page
     */
    public $logoutRedirect = null;

    /** @var bool Can't delete root user (id = 1) */
    public $cantDeleteRoot = true;

    /** @var array Default Settings */
    public static $defaultSettings = [
        'requireEmailConfirmation' => true,
        'loginEmail' => true,
        'loginUsername' => true,
        'loginDuration' => 2592000,
        'loginRedirect' => null,
        'logoutRedirect' => null,
        'cantDeleteRoot' => true,
    ];

    public static $menu =
        ['label' => 'Users', 'icon' => 'fa-users', 'items' => [
            ['label' => 'All users', 'url' => ['/admin/users/user']],
        ]];//,
      //  ['label' => 'Access', 'items' => [
       //     ['label' => 'Roles', 'url' => ['/admin/users/access/role']],
        //    ['label' => 'Permissions', 'url' => ['/admin/users/access/permission']],
        //]],
   // ;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        if (empty(Yii::$app->i18n->translations['userscube'])) {
            Yii::$app->i18n->translations['userscube'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }

/*    public function bootstrap($app)
    {
        // Add module URL rules.
        $app->urlManager->addRules(
            [
                '<_m:users>' => '<_m>/default/signin',
                '<_a:(signin|signup|signout)>' => 'users/default/<_a>',
            ],
            false
        );
    }*/
}