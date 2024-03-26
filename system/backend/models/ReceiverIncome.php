<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_income".
 *
 * @property int $id
 * @property int|null $receiver_income_type_id
 * @property string|null $branch_code
 * @property string|null $registration_year
 * @property string|null $description
 * @property float|null $amount_money
 * @property float|null $amount_rice
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $timestamp
 */
class ReceiverIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_income_type_id', 'created_by', 'updated_by'], 'integer'],
            [['registration_year', 'created_at', 'updated_at', 'timestamp'], 'safe'],
            [['description'], 'string'],
            [['amount_money', 'amount_rice'], 'number'],
            [['branch_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_income_type_id' => Yii::t('app', 'Receiver Income Type ID'),
            'branch_code' => Yii::t('app', 'Branch Code'),
            'registration_year' => Yii::t('app', 'Registration Year'),
            'description' => Yii::t('app', 'Description'),
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
