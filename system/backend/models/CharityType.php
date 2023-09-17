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
            [['name', 'desc'], 'required'],
            [['min', 'max', 'total_rice'], 'number'],
            [['is_rice'], 'integer'],
            [['timestamp'], 'safe'],
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
            'min' => Yii::t('app', 'min'),
            'max' => Yii::t('app', 'max'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getCharity()
    {
        return $this->hasMany(Charity::className(), ['id' => 'type_charity_id']);
    }
}
