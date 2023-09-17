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
            [['name', 'value'], 'required'],
            [['value'], 'integer'],
            [['timestamp'], 'safe'],
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
            'value' => Yii::t('app', 'Value'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
