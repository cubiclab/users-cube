<?php
namespace yii\userscube;

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