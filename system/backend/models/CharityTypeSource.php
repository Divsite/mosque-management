<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "charity_type_source".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $timestamp
 */
class CharityTypeSource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity_type_source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp'], 'safe'],
            [['code'], 'string', 'max' => 50],
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
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public static function getListCharityTypeSource()
    {
        return ArrayHelper::map(
            static::find()->all(), 'id', 'name'
        );
    }
}
