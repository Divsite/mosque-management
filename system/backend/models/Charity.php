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
            [['type_charity_id'], 'required'],
            [['type_charity_id'], 'integer'],
            [['customer_number'], 'string'],
            [['payment_date', 'timestamp'], 'safe'],
            // [['customer_address'], 'string', 'max' => 50],
            [['customer_name', 'payment_total', 'customer_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_charity_id' => Yii::t('app', 'Type Charity ID'),
            'customer_address' => Yii::t('app', 'Customer Address'),
            'customer_name' => Yii::t('app', 'Customer Name'),
            'customer_number' => Yii::t('app', 'Customer Number'),
            'payment_total' => Yii::t('app', 'Payment Total'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
