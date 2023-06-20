<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property string $province_name
 * @property string $city_name
 * @property string $district_name
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_name', 'city_name', 'district_name'], 'required'],
            [['province_name', 'city_name', 'district_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'province_name' => Yii::t('app', 'Province Name'),
            'city_name' => Yii::t('app', 'City Name'),
            'district_name' => Yii::t('app', 'District Name'),
        ];
    }
}
