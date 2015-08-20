<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 8:28
 */

namespace yii\userscube\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {


    /** @inheritdoc */
    public static function tableName(){
        return static::getDb()->tablePrefix . "user";
    }

    /** @inheritdoc */
    public function rules(){
        return [
            // login rules
            [['email', 'username'], 'required'],
            [['email', 'username'], 'string', 'max' => 255],
            [['email', 'username'], 'unique'],
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('usercubic', '{attribute} can contain only letters, numbers, and "_"')],

            // password rules
            [['newPassword'], 'string', 'min' => 4],
            [['newPassword'], 'filter', 'filter' => 'trim'],
            [['newPassword'], 'required', 'on' => ['register', 'reset']],
            [['newPasswordConfirm'], 'required', 'on' => ['reset']],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => Yii::t('usercubic','Passwords do not match')],
            [['currentPassword'], 'required', 'on' => ['account']],
            [['currentPassword'], 'validateCurrentPassword', 'on' => ['account']],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels(){
        return [
            // db fields
            'id'            => Yii::t('usercubic', 'ID'),
            'username'      => Yii::t('usercubic', 'Username'),
            'password'      => Yii::t('usercubic', 'Password'),
            'email'         => Yii::t('usercubic', 'Email'),
            'auth_key'      => Yii::t('usercubic', 'Auth Key'),
            'api_key'       => Yii::t('usercubic', 'Api Key'),
            'status'        => Yii::t('usercubic', 'Status'),
            'login_ip'      => Yii::t('usercubic', 'Login Ip'),
            'login_time'    => Yii::t('usercubic', 'Login Time'),
            'created_at'    => Yii::t('usercubic', 'Created At'),
            'updated_at'    => Yii::t('usercubic', 'Updated At'),
            'created_by'    => Yii::t('usercubic', 'Created By'),
            'updated_by'    => Yii::t('usercubic', 'Updated By'),
            // tech fields
            'currentPassword'    => Yii::t('usercubic', 'Current Password'),
            'newPassword'        => Yii::t('usercubic', 'New Password'),
            'newPasswordConfirm' => Yii::t('usercubic', 'New Password Confirm'),
        ];
    }

    /** @inheritdoc */
    public function behaviors(){
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /** @inheritdoc */
    public function getId(){
        return $this->id;
    }

    /** @inheritdoc */
    public static function findIdentity($id){
        return static::findOne($id);
    }

    /** @inheritdoc */
    public function getAuthKey(){
        return $this->auth_key;
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null){
        return static::findOne(["api_key" => $token]);
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validate Password
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /** @inheritdoc */
    public function beforeSave($insert){
        $return = parent::beforeSave($insert);

        if($this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        if($this->isNewRecord){
            $this->auth_key = Yii::$app->security->generateRandomKey($length = 255);
        }

        return $return;
    }




}
