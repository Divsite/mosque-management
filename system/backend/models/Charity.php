<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "charity".
 *
 * @property int $id
 * @property int $type_charity_id
 * @property string|null $customer_address
 * @property string|null $customer_name
 * @property string|null $customer_number
 * @property string|null $payment_total
 * @property string|null $payment_date
 * @property string|null $timestamp
 */
class Charity extends \yii\db\ActiveRecord
{
    const CHARITY_TYPE_MANUALLY = 1;
    const CHARITY_TYPE_AUTOMATIC = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_charity_id', 'type'], 'required'],
            [['type_charity_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_charity_id' => Yii::t('app', 'type_charity_id'),
            'type' => Yii::t('app', 'charity_type'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_by' => Yii::t('app', 'updated_by'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public static function find()
    {
        return new CharityQuery(get_called_class());
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->charityManually) {
                $this->charityManually->delete();
            }
            if ($this->charityZakatFitrah) {
                $this->charityZakatFitrah->delete();
            }
            if ($this->charityZakatFidyah) {
                $this->charityZakatFidyah->delete();
            }
            if ($this->charityInfaq) {
                $this->charityInfaq->delete();
            }
            if ($this->charitySodaqoh) {
                $this->charitySodaqoh->delete();
            }
            if ($this->charityZakatMal) {
                $this->charityZakatMal->delete();
            }
            if ($this->charityWaqaf) {
                $this->charityWaqaf->delete();
            }
            return true;
        }
        return false;
    }

    public function getCharityType()
    {
        return $this->hasOne(CharityType::class, ['id' => 'type_charity_id']);
    }

    public function getCharityManually()
    {
        return $this->hasOne(CharityManually::class, ['charity_id' => 'id']);
    }
    
    public function getCharityZakatFitrah()
    {
        return $this->hasOne(CharityZakatFitrah::class, ['charity_id' => 'id']);
    }
    
    public function getCharityZakatFidyah()
    {
        return $this->hasOne(CharityZakatFidyah::class, ['charity_id' => 'id']);
    }
    
    public function getCharityInfaq()
    {
        return $this->hasOne(CharityInfaq::class, ['charity_id' => 'id']);
    }
    
    public function getCharitySodaqoh()
    {
        return $this->hasOne(CharitySodaqoh::class, ['charity_id' => 'id']);
    }

    public function getCharityZakatMal()
    {
        return $this->hasOne(CharityZakatMal::class, ['charity_id' => 'id']);
    }
    
    public function getCharityWaqaf()
    {
        return $this->hasOne(CharityWaqaf::class, ['charity_id' => 'id']);
    }

    public function findCharityAutomatic($charityType) {
        switch ($charityType) {
            case $this->charityType->charitySource->code == "FTRH":
                return $this->charityZakatFitrah;
            case $this->charityType->charitySource->code == "FDYH":
                return $this->charityZakatFidyah;
            case $this->charityType->charitySource->code == "INFQ":
                return $this->charityInfaq;
            case $this->charityType->charitySource->code == "SQDH":
                return $this->charitySodaqoh;
            case $this->charityType->charitySource->code == "ZMAL":
                return $this->charityZakatMal;
            case $this->charityType->charitySource->code == "WQAF":
                return $this->charityWaqaf;
            default:
                return '-';
        }
    }

    public function getUserBranch()
    {
        return ['branch_code' => Yii::$app->user->identity->code];
    }

    public function getTypeManually()
    {
        return ['type' => self::CHARITY_TYPE_MANUALLY];
    }

    public function getTypeAutomatic()
    {
        return ['type' => self::CHARITY_TYPE_AUTOMATIC];
    }
}
