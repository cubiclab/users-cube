<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 21.08.2015
 * Time: 10:02
 */

namespace cubiclab\users\models\forms;

use Yii;
use yii\base\Model;
use cubiclab\users\traits\ModuleTrait;
use cubiclab\users\models\User;


/** SigninForm is the model behind the login form. */
class SigninForm extends Model {

    use ModuleTrait;

    /** @var string Username and/or email */
    public $username;

    /** @var string Password */
    public $password;

    /** @var bool If true, users will be logged in for $loginDuration */
    public $rememberMe = true;

    /** @var \cubiclab\users\models\User */
    protected $_user = false;

    /** @return array the validation rules. */
    public function rules() {
        return [
            [["username", "password"], "required"],
            ["username", "validateUser"],
            ["password", "validatePassword"],
            ["rememberMe", "boolean"],
        ];
    }

    /** Validate user */
    public function validateUser() {
        // check for valid user or if user registered using social auth
        $user = $this->getUser();
        if (!$user || !$user->password) {
            if ($this->module->loginEmail && $this->module->loginUsername) {
                $attribute = Yii::t('userscube', 'ATTR_EMAIL') . " / " . Yii::t('userscube', 'ATTR_USERNAME');
            } else {
                $attribute = $this->module->loginEmail ? Yii::t('userscube', 'ATTR_EMAIL') : Yii::t('userscube', 'ATTR_USERNAME');
            }
            $this->addError("username", $attribute . Yii::t("userscube", "ERR_NOT_FOUND"));
        }
    }

    /**
     * Validate password
     */
    public function validatePassword()
    {
        if ($this->hasErrors()) {
            return;
        }

        /** @var \cubiclab\users\models\User $user */
        $user = $this->getUser();
        if (!$user->validatePassword($this->password)) {
            $this->addError("password", Yii::t('userscube', "ERR_INCORRECT_PASSWORD"));
        }
    }

    /**
     * Get user based on email and/or username
     *
     * @return \cubiclab\users\models\User|null
     */
    protected function getUser()
    {
        // check if we need to get user
        if ($this->_user === false) {
            $user = User::find();
            if ($this->module->loginEmail) {
                $user->orWhere(["email" => $this->username]);
            }
            if ($this->module->loginUsername) {
                $user->orWhere(["username" => $this->username]);
            }
            // get and store user
            $this->_user = $user->one();
        }
        // return stored user
        return $this->_user;
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        // calculate attribute label for "username"
        if ($this->module->loginEmail && $this->module->loginUsername) {
            $attribute = Yii::t('userscube', 'ATTR_EMAIL') . " / " . Yii::t('userscube', 'ATTR_USERNAME');
        } else {
            $attribute = $this->module->loginEmail ? Yii::t('userscube', 'ATTR_EMAIL') : Yii::t('userscube', 'ATTR_USERNAME');
        }
        return [
            "username" => $attribute,
            "password" => Yii::t('userscube', 'ATTR_PASSWORD'),
            "rememberMe" => Yii::t('userscube', 'ATTR_REMEMBER_ME'),
        ];
    }

    /**
     * Validate and log user in
     *
     * @param int $loginDuration
     * @return bool
     */
    public function login($loginDuration)
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? $loginDuration : 0);
        }
        return false;
    }
}