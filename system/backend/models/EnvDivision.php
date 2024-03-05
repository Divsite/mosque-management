<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "env_division".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $obligation
 * @property string|null $timestamp
 */
class EnvDivision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'env_division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['obligation'], 'string'],
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
            'obligation' => Yii::t('app', 'Obligation'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
