<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_expense".
 *
 * @property int $id
 * @property int $receiver_type_id
 * @property int $receiver_operational_code
 * @property string $branch_code
 * @property string|null $registration_year
 * @property string|null $description
 * @property int $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $timestamp
 */
class ReceiverExpense extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_expense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_type_id', 'receiver_operational_code'], 'required'],
            [['receiver_type_id', 'created_by', 'updated_by'], 'integer'],
            [['registration_year', 'created_at', 'updated_at', 'timestamp'], 'safe'],
            [['description'], 'string'],
            [['amount'], 'number'],
            [['branch_code', 'receiver_operational_code'], 'string', 'max' => 50],
            [
                ['receiver_type_id', 'receiver_operational_code', 'branch_code'], 'unique', 
                'targetAttribute' => [
                    'receiver_type_id', 'receiver_operational_code', 'branch_code', 'registration_year'
                ],
                'message' => Yii::t('app', 'the_distribution_type_in_operations_in_has_been_used', [
                    'receiverType' => $this->receiverType ? $this->receiverType->name : null,
                    'operationalType' => $this->operationalType ? $this->operationalType->name : null,
                    'registrationYear' => $this->registration_year,
                ]),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_type_id' => Yii::t('app', 'receiver_type_id'),
            'receiver_operational_code' => Yii::t('app', 'receiver_operational_code'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'registration_year' => Yii::t('app', 'registration_year'),
            'description' => Yii::t('app', 'description'),
            'amount' => Yii::t('app', 'amount_expense'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_by' => Yii::t('app', 'updated_by'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->receiverExpenseDetails as $item) {
                $item->delete();
            }
            return true;
        }
        return false;
    }

    public function getOperationalType()
    {
        return $this->hasOne(ReceiverOperationalType::class, ['code' => 'receiver_operational_code']);
    }
    
    public function getReceiverType()
    {
        return $this->hasOne(ReceiverType::class, ['id' => 'receiver_type_id']);
    }

    public function getReceiverExpenseDetails()
    {
        return $this->hasMany(ReceiverExpenseDetail::className(), ['receiver_expense_id' => 'id']);
    }
}
