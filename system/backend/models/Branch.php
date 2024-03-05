<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property string $code
 * @property string $bch_type
 * @property string $bch_name
 * @property string $bch_address
 *
 * @property Customer[] $customers
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'bch_type', 'bch_name', 'bch_address'], 'required'],
            [['code', 'bch_type', 'bch_name'], 'string', 'max' => 50],
            [['bch_image', 'bch_image'], 'string', 'max' => 255],
            [['bch_address', 'desc'], 'string'],
            [['bch_category_id', 'floor_total', 'owner_status_id'], 'integer'],
            [['development_year', 'registration_date', 'timestamp'], 'safe'],
            [['floor_area', 'property_value'], 'number'],
            [['code'], 'unique'],
            [['bch_image', 'geographic_coordinate', 'building_owner', 'permit_certification'], 'string', 'max' => 255],
            [['bch_image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024 * 2, 'maxFiles' => 1 ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'code'),
            'bch_type' => Yii::t('app', 'branch_type'),
            'bch_name' => Yii::t('app', 'branch_name'),
            'bch_address' => Yii::t('app', 'branch_address'),
            'bch_image' => Yii::t('app', 'branch_logo'),
            'bch_category_id' => Yii::t('app', 'branch_category_id'),
            'development_year' => Yii::t('app', 'development_year'),
            'floor_area' => Yii::t('app', 'floor_area'),
            'floor_total' => Yii::t('app', 'floor_total'),
            'desc' => Yii::t('app', 'desc'),
            'geographic_coordinate' => Yii::t('app', 'geographic_coordinate'),
            'building_owner' => Yii::t('app', 'building_owner'),
            'permit_certification' => Yii::t('app', 'permit_certification'),
            'owner_status_id' => Yii::t('app', 'owner_status_id'),
            'property_value' => Yii::t('app', 'property_value'),
            'registration_date' => Yii::t('app', 'registration_date'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['code_branch' => 'code']);
    }
    
    public function getBranchCategory()
    {
        return $this->hasOne(BranchCategory::className(), ['id' => 'bch_category_id']);
    }
}
