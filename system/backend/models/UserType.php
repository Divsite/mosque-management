<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_type".
 *
 * @property string $code
 * @property string $table
 *
 * @property UserLevel[] $userLevels
 */
class UserType extends \yii\db\ActiveRecord
{
    const BRANCH = 'B';
    const CUSTOMER = 'P';
    const RESIDENT = 'W';
    const ENV = 'L';

    const YES_PARTNER = 1;
    const NO_PARTNER = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'table'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['table'], 'string', 'max' => 50],
            [['code'], 'unique'],
            [['is_partner'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'table' => 'Table',
            'is_partner' => 'Partner Nexcity',
        ];
    }

    /**
     * Gets query for [[UserLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserLevels()
    {
        return $this->hasMany(UserLevel::className(), ['type' => 'code']);
    }
}
