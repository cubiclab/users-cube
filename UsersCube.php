<?php
namespace cubiclab\users;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * @version 0.0.1-prealpha
 */
class UsersCube extends \yii\base\Module //implements BootstrapInterface
{

    /** @const VERSION Module version */
    const VERSION = "0.0.1-prealpha";

    /** @var string Alias for module */
    public $alias = "@usercube";

    /** @var boolean If true after registration user will be required to confirm his e-mail address. */
    public $requireEmailConfirmation = true;

    /** @var bool If true, users can log in using their email */
    public $loginEmail = true;

    /** @var bool If true, users can log in using their username */
    public $loginUsername = true;

    /** @var int Login duration */
    public $loginDuration = 3600 * 24 * 30;

    /**
     * @var array|string|null Url to redirect to after logging in. If null, will redirect to home page. Note that
     *                        AccessControl takes precedence over this (see [[yii\web\User::loginRequired()]])
     */
    public $loginRedirect = null;

    /**
     * @var array|string|null Url to redirect to after logging out. If null, will redirect to home page
     */
    public $logoutRedirect = null;

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        // set up i8n
        if (empty(Yii::$app->i18n->translations['userscube'])) {
            Yii::$app->i18n->translations['userscube'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        $this->setAliases([
            $this->alias => __DIR__,
        ]);

    }

/*    public function bootstrap($app)
    {
        Yii::setAlias('userscube', '@vendor/cubiclab/users-cube');
    }*/
}