<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity_type".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property float|null $min
 * @property float|null $max
 * @property string|null $timestamp
 */
class CharityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'required'],
            [['min', 'max'], 'number'],
            [['timestamp'], 'safe'],
            [['name', 'desc'], 'string', 'max' => 255],
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
            'desc' => Yii::t('app', 'Desc'),
            'min' => Yii::t('app', 'Min'),
            'max' => Yii::t('app', 'Max'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
