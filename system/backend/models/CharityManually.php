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
            // [['charity_id'], 'required'],
            [['charity_id'], 'integer'],
            [['customer_address'], 'string'],
            [['payment_total', 'total_rice'], 'number'],
            [['payment_date', 'timestamp'], 'safe'],
            [['customer_email'], 'email'],
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
            'charity_id' => Yii::t('app', 'charity_id'),
            'customer_name' => Yii::t('app', 'customer_name'),
            'customer_email' => Yii::t('app', 'customer_email'),
            'customer_address' => Yii::t('app', 'customer_address'),
            'customer_number' => Yii::t('app', 'customer_number'),
            'payment_total' => Yii::t('app', 'payment_total'),
            'payment_date' => Yii::t('app', 'payment_date'),
            'total_rice' => Yii::t('app', 'total_rice'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getCharity()
    {
        return $this->hasOne(Charity::class, ['id' => 'charity_id']);
    }
}
