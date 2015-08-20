<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 16:41
 */

namespace yii\userscube\traits;

use Yii;
use yii\userscube\UsersCube;

/**
 * Class ModuleTrait
 * @package vova07\users\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait{
    /** @var \yii\userscube\UsersCube|null Module instance */
    private $_module;

    /** @return \yii\userscube\UsersCube|null Module instance */
    public function getModule(){
        if ($this->_module === null) {
            $module = UsersCube::getInstance();
            if ($module instanceof UsersCube) {
                $this->_module = $module;
            } else {
                $this->_module = Yii::$app->getModule('userscube');
            }
        }
        return $this->_module;
    }
}