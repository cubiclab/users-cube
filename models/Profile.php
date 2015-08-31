<?php

namespace cubiclab\users\models;

use Yii;

/**
 * This is the model class for table "{{%users_profiles}}".
 *
 * @property integer $user_id
 * @property string $first_name
 * @property string $surname
 * @property string $patronymic
 * @property string $birth_date
 * @property integer $gender
 * @property string $phone
 * @property string $address
 * @property string $notes
 *
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_profiles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birth_date'], 'safe'],
            [['gender'], 'integer'],
            [['notes'], 'string'],
            [['first_name', 'surname', 'patronymic'], 'string', 'max' => 50],
            [['phone', 'address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'surname' => Yii::t('app', 'Surname'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'gender' => Yii::t('app', 'Gender'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'notes' => Yii::t('app', 'Notes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
