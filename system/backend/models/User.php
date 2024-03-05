<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $type
 * @property string $code
 * @property string $level
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property string $name
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'code', 'level', 'username', 'password', 'password_repeat', 'auth_key', 'password_hash', 'email', 'name', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 2],
            [['code', 'level', 'name'], 'string', 'max' => 50],
            [['username', 'password_hash', 'password_reset_token', 'email', 'image', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password', 'password_repeat'], 'string', 'min' => 4],
            [['password_reset_token'], 'unique'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message' => "Passwords tidak sama" ],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024 * 2, 'maxFiles' => 1 ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => Yii::t('app', 'type'),
            'code' => Yii::t('app', 'code'),
            'level' => Yii::t('app', 'level'),
            'username' => Yii::t('app', 'username'),
            'auth_key' => Yii::t('app', 'auth_key'),
            'password_hash' => Yii::t('app', 'password'),
            'password_reset_token' => Yii::t('app', 'password_reset_token'),
            'email' => Yii::t('app', 'email'),
            'name' => Yii::t('app', 'name'),
            'image' => Yii::t('app', 'image'),
            'status' => Yii::t('app', 'status'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'verification_token' => Yii::t('app', 'verification_token'),
        ];
    }

    public function getResidents()
    {
        return $this->hasMany(Resident::class, ['user_id' => 'id']);
    }
    
    public function getOfficers()
    {
        return $this->hasMany(Officer::class, ['user_id' => 'id']);
    }

    public static function findResidentsByCode($code)
    {
        return static::find()
            ->where(['code' => $code])
            ->all();
    }
}
