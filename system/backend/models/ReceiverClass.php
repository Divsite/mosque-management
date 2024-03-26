<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "receiver_class".
 *
 * @property int $id
 * @property string $name
 * @property float|null $get_money
 * @property int|null $get_rice
 * @property string|null $timestamp
 */
class ReceiverClass extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const NONACTIVE = 0;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['receiver_class_source_id', 'validateUniqueReceiverClassSource', 'on' => 'create'],
            [['receiver_class_source_id'], 'required'],
            [['get_money', 'get_rice'], 'number'],
            [['is_active', 'receiver_class_source_id'], 'integer'],
            [['branch_code'], 'string', 'max' => 50],
            [['timestamp', 'registration_year'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'name'),
            'receiver_class_source_id' => Yii::t('app', 'receiver_class_source_id'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'get_money' => Yii::t('app', 'get_money'),
            'get_rice' => Yii::t('app', 'get_rice'),
            'is_active' => Yii::t('app', 'is_active'),
            'registration_year' => Yii::t('app', 'registration_year'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getReceiverClassSource()
    {
        return $this->hasOne(ReceiverClassSource::class, ['id' => 'receiver_class_source_id']);
    }

    public static function getListReceiverClass()
    {
        return ArrayHelper::map(
            static::find()
                ->with('receiverClassSource')
                ->where([
                    'branch_code' => Yii::$app->user->identity->code, 
                    'is_active' => self::ACTIVE,
                    'registration_year' => date('Y')
                ])
                ->all(), 'id', 'receiverClassSource.name'
        );
    }

    public function validateUniqueReceiverClassSource($attribute)
    {
        $year = date('Y');
        $existingReceiverClassByThisYear = ReceiverClass::find()
            ->where(['receiver_class_source_id' => $this->$attribute])
            ->andWhere(['YEAR(registration_year)' => $year])
            ->one();

        if ($existingReceiverClassByThisYear) {
            $receiverClassSourceName = $existingReceiverClassByThisYear->receiverClassSource->name;
            $this->addError($attribute, Yii::t('app', 'receiver_source_class_must_be_unique_within_the_same_year', [
                'receiverClassSourceName' => $receiverClassSourceName
            ]));
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['receiver_class_source_id'];
        $scenarios[self::SCENARIO_UPDATE] = $this->attributes();
        return $scenarios;
    }
}
