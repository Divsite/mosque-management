<?php

namespace backend\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "env".
 *
 * @property int $id
 * @property string $code
 * @property int $village_id
 * @property int $citizen_association_id
 * @property int $neighborhood_association_id
 * @property string|null $responbility
 * @property string|null $telp
 * @property string|null $email
 * @property string|null $periode
 */
class Env extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'env';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province', 'city', 'district', 'telp', 'periode'], 'string', 'max' => 50],
            [['registration_date'], 'safe'],
            [['nik', 'user_id', 'citizen_association_id', 'neighborhood_association_id', 'village_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => StringHelper::mb_ucwords(Yii::t('app', 'chief_name')),
            'province' => StringHelper::mb_ucwords(Yii::t('app', 'province')),
            'city' => StringHelper::mb_ucwords(Yii::t('app', 'city')),
            'district' => StringHelper::mb_ucwords(Yii::t('app', 'district')),
            'telp' => StringHelper::mb_ucwords(Yii::t('app', 'telp')),
            'periode' => StringHelper::mb_ucwords(Yii::t('app', 'Periode')),
            'registration_date' => StringHelper::mb_ucwords(Yii::t('app', 'registration_date')),
            'nik' => StringHelper::mb_ucwords(Yii::t('app', 'nik')),
            'citizen_association_id' => StringHelper::mb_ucwords(Yii::t('app', 'citizens_association_id')),
            'neighborhood_association_id' => StringHelper::mb_ucwords(Yii::t('app', 'neighborhood_association_id')),
            'village_id' => StringHelper::mb_ucwords(Yii::t('app', 'village_id')),
        ];
    }

    public function getVillage()
    {
        return $this->hasOne(Village::class, ['id' => 'village_id']);
    }
    
    public function getCitizen()
    {
        return $this->hasOne(CitizensAssociation::class, ['id' => 'citizen_association_id']);
    }
    
    public function getNeighborhood()
    {
        return $this->hasOne(NeighborhoodAssociation::class, ['id' => 'neighborhood_association_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
