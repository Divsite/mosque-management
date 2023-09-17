<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "populate".
 *
 * @property int $id
 * @property string $code
 * @property string $village_id
 * @property int $citizen_association_id
 * @property int $neighborhood_association_id
 */
class Populate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'populate';
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
            [['code', 'village_id', 'citizen_association_id', 'neighborhood_association_id'], 'required'],
            [['citizen_association_id', 'neighborhood_association_id'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['village_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'village_id' => Yii::t('app', 'Village ID'),
            'citizen_association_id' => Yii::t('app', 'Citizen Association ID'),
            'neighborhood_association_id' => Yii::t('app', 'Neighborhood Association ID'),
        ];
    }

    public function getVillage()
    {
        return $this->hasOne(Village::class, ['id' => 'village_id'])->with('location');
    }

    public function getCitizenAssociation()
    {
        return $this->hasOne(CitizensAssociation::class, ['id' => 'citizen_association_id']);
    }

    public function getNeighborhoodAssociation()
    {
        return $this->hasOne(NeighborhoodAssociation::class, ['id' => 'neighborhood_association_id']);
    }
}
