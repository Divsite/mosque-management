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
            [['branch_code', 'name', 'desc'], 'required'],
            [['min', 'max', 'total_rice', 'package'], 'number'],
            [['is_rice', 'is_active'], 'integer'],
            [['timestamp'], 'safe'],
            [['branch_code'], 'string', 'max' => 50],
            [['name', 'desc'], 'string', 'max' => 255],
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
            'desc' => Yii::t('app', 'desc'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'min' => Yii::t('app', 'min'),
            'max' => Yii::t('app', 'max'),
            'total_rice' => Yii::t('app', 'total_rice'),
            'package' => Yii::t('app', 'package'),
            'is_rice' => Yii::t('app', 'is_rice'),
            'is_active' => Yii::t('app', 'is_active'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getCharity()
    {
        return $this->hasMany(Charity::className(), ['id' => 'type_charity_id']);
    }
}
