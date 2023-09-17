<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity".
 *
 * @property int $id
 * @property int $type_charity_id
 * @property string|null $customer_address
 * @property string|null $customer_name
 * @property string|null $customer_number
 * @property string|null $payment_total
 * @property string|null $payment_date
 * @property string|null $timestamp
 */
class Charity extends \yii\db\ActiveRecord
{
    const CHARITY_TYPE_MANUALLY = 1;
    const CHARITY_TYPE_AUTOMATIC = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_charity_id', 'type'], 'required'],
            [['type_charity_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_charity_id' => Yii::t('app', 'type_charity_id'),
            'type' => Yii::t('app', 'charity_type'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_by' => Yii::t('app', 'updated_by'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getCharityType()
    {
        return $this->hasOne(CharityType::class, ['id' => 'type_charity_id']);
    }
}
