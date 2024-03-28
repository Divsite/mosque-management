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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
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
            [['receiver_income_id', 'created_by', 'updated_by'], 'integer'],
            [['money', 'rice'], 'number'],
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
            'receiver_income_id' => Yii::t('app', 'receiver_income_id'),
            'name' => Yii::t('app', 'name'),
            'money' => Yii::t('app', 'get_money'),
            'rice' => Yii::t('app', 'rice'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $this->attributes();
        $scenarios[self::SCENARIO_UPDATE] = $this->attributes();
        return $scenarios;
    }

    public function getReceiverExpense()
    {
        return $this->hasOne(ReceiverIncome::class, ['id' => 'receiver_income_id']);
    }
}
