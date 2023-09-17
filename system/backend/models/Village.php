<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "village".
 *
 * @property int $id
 * @property int $location_id
 * @property string $name
 * @property string $postcode
 */
class Village extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'village';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_id', 'name', 'postcode'], 'required'],
            [['location_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'location_id' => Yii::t('app', 'Location ID'),
            'name' => Yii::t('app', 'Name'),
            'postcode' => Yii::t('app', 'Postcode'),
        ];
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }
}
