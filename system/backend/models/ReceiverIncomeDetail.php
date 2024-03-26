<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_income_detail".
 *
 * @property int $id
 * @property int|null $receiver_income_id
 * @property int|null $receiver_income_type_id
 * @property string|null $name
 * @property float|null $money
 * @property string|null $rice
 * @property float|null $amount_money
 * @property float|null $amount_rice
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $timestamp
 */
class ReceiverIncomeDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_income_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_income_id', 'receiver_income_type_id', 'created_by', 'updated_by'], 'integer'],
            [['money', 'amount_money', 'amount_rice'], 'number'],
            [['rice'], 'string'],
            [['created_at', 'updated_at', 'timestamp'], 'safe'],
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
            'receiver_income_id' => Yii::t('app', 'Receiver Income ID'),
            'receiver_income_type_id' => Yii::t('app', 'Receiver Income Type ID'),
            'name' => Yii::t('app', 'Name'),
            'money' => Yii::t('app', 'Money'),
            'rice' => Yii::t('app', 'Rice'),
            'amount_money' => Yii::t('app', 'Amount Money'),
            'amount_rice' => Yii::t('app', 'Amount Rice'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
