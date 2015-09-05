<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 16:41
 */

namespace cubiclab\users\traits;

use Yii;
use cubiclab\users\UsersCube;

/**
 * Class ModuleTrait
 * @package yii\userscube\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait{
    /** @var \cubiclab\users\UsersCube|null Module instance */
    private $_module;

    /** @return \cubiclab\users\UsersCube|null Module instance */
    public function getModule(){
        if ($this->_module === null) {
            $module = UsersCube::getInstance();
            if ($module instanceof UsersCube) {
                $this->_module = $module;
            } else {
                $this->_module = Yii::$app->getModule('users');
            }
        }
        return $this->_module;
    }
}