<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_income_type".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $timestamp
 */
class ReceiverIncomeType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_income_type';
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
}
