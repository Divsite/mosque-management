<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity_zakat_fitrah_package".
 *
 * @property int $id
 * @property string $name
 * @property int $value
 * @property string|null $timestamp
 */
class CharityZakatFitrahPackage extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const NONACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity_zakat_fitrah_package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'branch_code'], 'required'],
            [['value', 'is_active'], 'integer'],
            [['timestamp'], 'safe'],
            [['branch_code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'value' => Yii::t('app', 'Value'),
            'is_active' => Yii::t('app', 'is_active'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
