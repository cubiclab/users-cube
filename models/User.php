<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 8:28
 */

namespace cubiclab\users\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use cubiclab\users\traits\ModuleTrait;

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
    /** @var string Model status. */
    private $_status;

    public $role;

     /** @inheritdoc */
    public static function tableName(){
        return '{{%users}}';
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
            [['password'], 'required', 'on' => ['register', 'reset', 'admin-create']],

            [['status'], 'safe', 'on' => ['admin-create']],

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
            'avatar'        => Yii::t('userscube', 'ATTR_AVATAR'),
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

    /**
     * getUserName
     *
     * @return string Username
     */
    public function getUserName(){
        return $this->username;
    }

    /** @inheritdoc */
    public static function findIdentity($id){
        return static::findOne($id);
    }

    /**
     * Find users by IDs.
     *
     * @param $ids Users IDs
     * @param null $scope Scope
     *
     * @return array|\yii\db\ActiveRecord[] Users
     */
    public static function findIdentities($ids, $scope = null)
    {
        $query = static::find()->where(['id' => $ids]);
        if ($scope !== null) {
            if (is_array($scope)) {
                foreach ($scope as $value) {
                    $query->$value();
                }
            } else {
                $query->$scope();
            }
        }
        return $query->all();
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersProfiles()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /** @return array Status array. */
    public static function getStatusArray(){
        return [
            self::STATUS_INACTIVE   => Yii::t('userscube', 'STATUS_INACTIVE'),
            self::STATUS_ACTIVE     => Yii::t('userscube', 'STATUS_ACTIVE'),
            self::STATUS_BLOCKED    => Yii::t('userscube', 'STATUS_BLOCKED'),
            self::STATUS_DELETED    => Yii::t('userscube', 'STATUS_DELETED'),
        ];
    }

    /** @return string Model status. */
    public function getStatusName(){
        if ($this->_status === null) {
            $statuses = self::getStatusArray();
            $this->_status = $statuses[$this->status];
        }
        return $this->_status;
    }

    public function getUserRolesNames()
    {
        $user_roles = Yii::$app->authManager->getRolesByUser($this->id);
        $user_roles_names = '';
        foreach($user_roles as $role){
            $user_roles_names .= $role->name;
        }
        return $user_roles_names;
    }

    /** Deside delete user or just set a deleted status */
    public function delete(){
        if(!($this->id == 1 && $this->module->cantDeleteRoot == true)){
            if ($this->status == self::STATUS_DELETED) {
                Yii::$app->authManager->revokeAll($this->getId());
                parent::delete();
            } else {
                $this->status = self::STATUS_DELETED;
                $this->save(false); // validation = false
            }
        }
    }

}
