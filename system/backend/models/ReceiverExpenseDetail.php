<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_expense_detail".
 *
 * @property int $id
 * @property int $receiver_expense_id
 * @property int $officer_id
 * @property string $name
 * @property string|null $price
 * @property string|null $qty
 * @property float|null $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $timestamp
 */
class ReceiverExpenseDetail extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_expense_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qty', 'price'], 'required'],
            [['receiver_expense_id', 'officer_id', 'created_by', 'updated_by', 'qty', 'receiver_class_id'], 'integer'],
            [['created_at', 'updated_at', 'timestamp'], 'safe'],
            [['amount'], 'number'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            ['officer_id', 'uniqueByReceiverExpenseId'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_expense_id' => Yii::t('app', 'receiver_expense_id'),
            'receiver_class_id' => Yii::t('app', 'receiver_class_id'),
            'officer_id' => Yii::t('app', 'officer_id'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'qty' => Yii::t('app', 'Qty'),
            'amount' => Yii::t('app', 'Amount'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public function getReceiverExpense()
    {
        return $this->hasOne(ReceiverExpense::class, ['id' => 'receiver_expense_id']);
    }

    public function getOfficer()
    {
        return $this->hasOne(Officer::class, ['id' => 'officer_id']);
    }

    public function uniqueByReceiverExpenseId($attribute, $params)
    {
        if ($this->scenario == ReceiverExpenseDetail::SCENARIO_CREATE) {
            $detailExpenses = Yii::$app->request->post('ReceiverExpenseDetail');

            $officerIds = [];
            $duplicateOfficerId = false;

            foreach ($detailExpenses as $detailExpense) {
                $officerId = $detailExpense['officer_id'];
                if (in_array($officerId, $officerIds)) {
                    $duplicateOfficerId = true;
                    break;
                }
                $officerIds[] = $officerId;
            }

            if ($duplicateOfficerId) {
                $this->addError($attribute, Yii::t('app', 'no_more_than_one_officer_may_be_selected'));
            }
        } elseif ($this->scenario == ReceiverExpenseDetail::SCENARIO_UPDATE) {

            $detailExpenses = Yii::$app->request->post('ReceiverExpenseDetail');
            $duplicateOfficerId = false;

            foreach ($detailExpenses as $detailExpense) {
                $officerId = $detailExpense['officer_id'];
            
                $existingRecord = ReceiverExpenseDetail::find()
                    ->where([
                        'receiver_expense_id' => $this->receiver_expense_id,
                        'officer_id' => $officerId,
                    ])
                    ->exists();
            
                if ($existingRecord) {
                    $duplicateOfficerId = true;
                    break;
                }
            }

            if ($existingRecord) {
                $this->addError($attribute, Yii::t('app', 'the_officer_already_assigned', [
                    'officerName' => $this->officer ? $this->officer->user->name : null,
                ]));
            }
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $this->attributes();
        $scenarios[self::SCENARIO_UPDATE] = $this->attributes();
        return $scenarios;
    }
}
