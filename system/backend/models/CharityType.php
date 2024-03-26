<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity_type".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property float|null $min
 * @property float|null $max
 * @property int|null $is_rice
 * @property float|null $total_rice
 * @property string|null $timestamp
 */
class CharityType extends \yii\db\ActiveRecord
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
        return 'charity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc', 'charity_type_source_id'], 'required'],
            [['min', 'max', 'total_rice', 'package'], 'number'],
            [['charity_type_source_id', 'is_rice', 'is_active'], 'integer'],
            ['charity_type_source_id', 'validateUniqueCharityTypeSource', 'on' => 'create'],
            [['timestamp', 'registration_year'], 'safe'],
            [['branch_code'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'charity_type_source_id' => Yii::t('app', 'charity_type_source_id'),
            'desc' => Yii::t('app', 'desc'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'min' => Yii::t('app', 'min'),
            'max' => Yii::t('app', 'max'),
            'total_rice' => Yii::t('app', 'total_rice'),
            'package' => Yii::t('app', 'package'),
            'is_rice' => Yii::t('app', 'is_rice'),
            'is_active' => Yii::t('app', 'is_active'),
            'registration_year' => Yii::t('app', 'registration_year'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getCharity()
    {
        return $this->hasMany(Charity::className(), ['id' => 'type_charity_id']);
    }

    public function getCharitySource()
    {
        return $this->hasOne(CharityTypeSource::class, ['id' => 'charity_type_source_id']);
    }

    public function validateUniqueCharityTypeSource($attribute)
    {
        $year = date('Y');
        $existingCharityTypeByThisYear = CharityType::find()
            ->where(['charity_type_source_id' => $this->$attribute])
            ->andWhere(['YEAR(registration_year)' => $year])
            ->one();

        if ($existingCharityTypeByThisYear) {
            $charityTypeSourceName = $existingCharityTypeByThisYear->charitySource->name;
            $this->addError($attribute, Yii::t('app', 'charity_type_must_be_unique_within_the_same_year', [
                'charityTypeSourceName' => $charityTypeSourceName
            ]));
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['charity_type_source_id'];
        $scenarios[self::SCENARIO_UPDATE] = $this->attributes();
        return $scenarios;
    }
}
