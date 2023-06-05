<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $timestamp
 */
class ReceiverType extends \yii\db\ActiveRecord
{

    const ZAKAT = 1;
    const SACRIFICE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
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
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
