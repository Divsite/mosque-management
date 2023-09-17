<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity_zakat_mal".
 *
 * @property int $id
 * @property int $charity_id
 * @property float $total_income
 * @property float|null $other_income
 * @property float|null $spending
 * @property string|null $customer_name
 * @property string|null $customer_address
 * @property string|null $customer_number
 * @property string|null $customer_email
 * @property float|null $payment_total
 * @property string|null $payment_date
 * @property string|null $timestamp
 */
class CharityZakatMal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity_zakat_mal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['charity_id'], 'required'],
            [['charity_id'], 'integer'],
            [['total_income', 'other_income', 'spending', 'payment_total'], 'number'],
            [['customer_address'], 'string'],
            [['payment_date', 'timestamp'], 'safe'],
            [['customer_name', 'customer_number', 'customer_email'], 'string', 'max' => 255],
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
            'total_income' => Yii::t('app', 'Total Income'),
            'other_income' => Yii::t('app', 'Other Income'),
            'spending' => Yii::t('app', 'Spending'),
            'customer_name' => Yii::t('app', 'Customer Name'),
            'customer_address' => Yii::t('app', 'Customer Address'),
            'customer_number' => Yii::t('app', 'Customer Number'),
            'customer_email' => Yii::t('app', 'Customer Email'),
            'payment_total' => Yii::t('app', 'Payment Total'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
