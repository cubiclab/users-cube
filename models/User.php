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

use yii\userscube\traits\ModuleTrait;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    use ModuleTrait;

    /** Inactive status */
    const STATUS_INACTIVE = 0;
    /** Active status */
    const STATUS_ACTIVE = 1;
    /** Banned status */
    const STATUS_BLOCKED = 2;
    /** Deleted status */
    const STATUS_DELETED = 3;

     /** @inheritdoc */
    public static function tableName(){
        return static::getDb()->tablePrefix . "users";
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
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('userscube', 'PATTERN_USERNAME')],

            // password rules
            [['password'], 'string', 'min' => 4],
            [['password'], 'filter', 'filter' => 'trim'],
            [['password'], 'required', 'on' => ['register', 'reset']]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels(){
        return [
            // db fields
            'id'            => Yii::t('userscube', 'ATTR_ID'),
            'username'      => Yii::t('userscube', 'ATTR_USERNAME'),
            'password'      => Yii::t('userscube', 'ATTR_PASSWORD'),
            'email'         => Yii::t('userscube', 'ATTR_EMAIL'),
            'auth_key'      => Yii::t('userscube', 'ATTR_AUTH_KEY'),
            'api_key'       => Yii::t('userscube', 'ATTR_API_KEY'),
            'status'        => Yii::t('userscube', 'ATTR_STATUS'),
            'login_ip'      => Yii::t('userscube', 'ATTR_LOGIN_IP'),
            'login_time'    => Yii::t('userscube', 'ATTR_LOGIN_TIME'),
            'created_at'    => Yii::t('userscube', 'ATTR_CREATED_AT'),
            'updated_at'    => Yii::t('userscube', 'ATTR_UPDATED_AT'),
            'created_by'    => Yii::t('userscube', 'ATTR_CREATED_BY'),
            'updated_by'    => Yii::t('userscube', 'ATTR_UPDATED_BY'),
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameableBehavior' => [
                'class' => BlameableBehavior::className(),
            ],
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
        if (parent::beforeSave($insert)) {
            if($this->isAttributeChanged('password')) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }

            if ($this->isNewRecord) {
                if (!$this->status) {
                    $this->status = $this->module->requireEmailConfirmation ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
                }

                // Generate auth
                $this->auth_key = Yii::$app->security->generateRandomKey($length = 255);
            }
            return true;
        }
        return false;
    }





}
