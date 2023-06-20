<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "married_status".
 *
 * @property int $id
 * @property string $name
 * @property string|null $timestamp
 */
class MarriedStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'married_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 50],
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
