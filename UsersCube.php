<?php
namespace yii\userscube;

use Yii;
use yii\base\BootstrapInterface;

class UsersCube extends \yii\base\Module implements BootstrapInterface
{
    const VERSION = "0.0.1-prealpha";

    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        Yii::setAlias('userscube', '@vendor/cubiclab/users-cube');

    }
}