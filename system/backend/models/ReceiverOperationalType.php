<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_operational_type".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $registration_year
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $timestamp
 */
class ReceiverOperationalType extends \yii\db\ActiveRecord
{
    const OFFICER = "OFF";
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_operational_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'created_by', 'updated_by'], 'required'],
            [['description'], 'string'],
            [['registration_year', 'created_at', 'updated_at', 'timestamp'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
            'description' => Yii::t('app', 'Description'),
            'registration_year' => Yii::t('app', 'Registration Year'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    
}
