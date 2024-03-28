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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
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
            [['receiver_income_type_id', 'receiver_type_id', 'created_by', 'updated_by'], 'integer'],
            [['registration_year', 'created_at', 'updated_at', 'timestamp'], 'safe'],
            [['description'], 'string'],
            [['amount_money', 'amount_rice'], 'number'],
            [['branch_code'], 'string', 'max' => 50],
            [
                ['receiver_type_id', 'receiver_income_type_id', 'branch_code'], 'unique', 
                'targetAttribute' => [
                    'receiver_type_id', 'receiver_income_type_id', 'branch_code', 'registration_year'
                ],
                'message' => Yii::t('app', 'the_income_type_in_income_type_in_has_been_used', [
                    'receiverType' => $this->receiverType ? $this->receiverType->name : null,
                    'receiverIncomeType' => $this->receiverIncomeType ? $this->receiverIncomeType->name : null,
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
            'receiver_income_type_id' => Yii::t('app', 'receiver_income_type_id'),
            'receiver_type_id' => Yii::t('app', 'receiver_type_id'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'registration_year' => Yii::t('app', 'registration_year'),
            'description' => Yii::t('app', 'description'),
            'amount_money' => Yii::t('app', 'amount_money'),
            'amount_rice' => Yii::t('app', 'amount_rice'),
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
            foreach ($this->receiverIncomeDetails as $item) {
                $item->delete();
            }
            return true;
        }
        return false;
    }

    public function getReceiverIncomeType()
    {
        return $this->hasOne(ReceiverIncomeType::class, ['id' => 'receiver_income_type_id']);
    }
    
    public function getReceiverType()
    {
        return $this->hasOne(ReceiverType::class, ['id' => 'receiver_type_id']);
    }

    public function getReceiverIncomeDetails()
    {
        return $this->hasMany(ReceiverIncomeDetail::className(), ['receiver_income_id' => 'id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $this->attributes();
        $scenarios[self::SCENARIO_UPDATE] = $this->attributes();
        return $scenarios;
    }
}
