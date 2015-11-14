<?php
/**
 * Created by PhpStorm.
 * User: Pt1c
 * Date: 13.11.2015
 * Time: 23:28
 */

namespace cubiclab\users\models;

use cubiclab\users\UsersCube;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use cubiclab\users\traits\ModuleTrait;

class UserToken extends ActiveRecord
{

    use ModuleTrait;

    /** Token for email activation */
    const TYPE_EMAIL_ACTIVATE = 0;
    /** Token for email change */
    const TYPE_EMAIL_CHANGE = 1;
    /** Token for password reset */
    const TYPE_PASSWORD_RESET = 3;

    /** @inheritdoc */
    public static function tableName(){
        return '{{%users_token}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => UsersCube::t('userscube', 'ATTR_ID'),
            'user_id'       => UsersCube::t('userscube', 'ATTR_USER_ID'),
            'type'          => UsersCube::t('userscube', 'ATTR_TOKEN_TYPE'),
            'token'         => UsersCube::t('userscube', 'ATTR_TOKEN'),
            'data'          => UsersCube::t('userscube', 'ATTR_TOKEN_DATA'),
            'created_at'    => UsersCube::t('userscube', 'ATTR_CREATED_AT'),
            'expired_at'    => UsersCube::t('userscube', 'ATTR_UPDATED_AT'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Generate/reuse a userToken
     * @param int $userId
     * @param int $type
     * @param string $data
     * @param string $expireTime
     * @return static
     */
    public static function generate($userId, $type, $data = null, $expireTime = null)
    {
        // attempt to find existing record
        // otherwise create new
        $checkExpiration = false;
        if ($userId) {
            $model = static::findByUser($userId, $type, $checkExpiration);
        } else {
            $model = static::findByData($data, $type, $checkExpiration);
        }
        if (!$model) {
            $model = new static();
        }
        // set/update data
        $model->user_id = $userId;
        $model->type = $type;
        $model->data = $data;
        $model->expired_at = $expireTime;
        $model->token = Yii::$app->security->generateRandomString();
        $model->save();
        return $model;
    }

    /**
     * Find a userToken by specified field/value
     * @param string $field
     * @param string $value
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findBy($field, $value, $type, $checkExpiration)
    {
        $query = static::find()->where([$field => $value, "type" => $type ]);
        if ($checkExpiration) {
            $now = gmdate("Y-m-d H:i:s");
            $query->andWhere("([[expired_at]] >= '$now' or [[expired_at]] is NULL)");
        }
        return $query->one();
    }

    /**
     * Find a userToken by userId
     * @param int $userId
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByUser($userId, $type, $checkExpiration = true)
    {
        return static::findBy("user_id", $userId, $type, $checkExpiration);
    }

    /**
     * Find a userToken by token
     * @param string $token
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByToken($token, $type, $checkExpiration = true)
    {
        return static::findBy("token", $token, $type, $checkExpiration);
    }

    /**
     * Find a userToken by data
     * @param string $data
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByData($data, $type, $checkExpiration = true)
    {
        return static::findBy("data", $data, $type, $checkExpiration);
    }
}