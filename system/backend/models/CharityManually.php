<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity_manually".
 *
 * @property int $id
 * @property int $charity_id
 * @property string|null $customer_name
 * @property string|null $customer_email
 * @property string|null $customer_address
 * @property string|null $customer_number
 * @property float|null $payment_total
 * @property string|null $payment_date
 * @property string|null $timestamp
 */
class CharityManually extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity_manually';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['charity_id'], 'required'],
            [['charity_id'], 'integer'],
            [['customer_address'], 'string'],
            [['payment_total'], 'number'],
            [['payment_date', 'timestamp'], 'safe'],
            [['customer_name', 'customer_email', 'customer_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'charity_id' => Yii::t('app', 'Charity ID'),
            'customer_name' => Yii::t('app', 'Customer Name'),
            'customer_email' => Yii::t('app', 'Customer Email'),
            'customer_address' => Yii::t('app', 'Customer Address'),
            'customer_number' => Yii::t('app', 'Customer Number'),
            'payment_total' => Yii::t('app', 'Payment Total'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
