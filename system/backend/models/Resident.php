<?php

namespace backend\models;

use Yii;


use backend\models\User;

/**
 * This is the model class for table "resident".
 *
 * @property int $id
 * @property string|null $user_id
 * @property int|null $nik
 * @property string|null $telp
 * @property string|null $identity_card_image
 * @property string|null $home_image
 * @property string|null $birth_place
 * @property string|null $birth_date
 * @property int|null $gender_id
 * @property int|null $education_id
 * @property int|null $education_major_id
 * @property int|null $married_status_id
 * @property int|null $nationality_id
 * @property int|null $religion_id
 * @property int|null $residence_status_id
 * @property string|null $province
 * @property string|null $city
 * @property string|null $district
 * @property string|null $postcode
 * @property int|null $citizen_id
 * @property int|null $neighborhood_id
 * @property string|null $address
 * @property int|null $family_head_status
 * @property int|null $dependent_number
 * @property string|null $interest
 * @property string|null $registration_date
 */
class Resident extends \yii\db\ActiveRecord
{
    const FAMILY_HEAD_YES = 1;
    const FAMILY_HEAD_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resident';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nik', 'gender_id', 'education_id', 'education_major_id', 'married_status_id', 'nationality_id', 'religion_id', 'residence_status_id', 'citizen_association_id', 'neighborhood_association_id', 'family_head_status', 'dependent_number', 'village_id'], 'integer'],
            [['birth_date', 'registration_date'], 'safe'],
            [['address'], 'string'],
            [['user_id', 'telp', 'identity_card_image', 'home_image', 'birth_place', 'interest'], 'string', 'max' => 255],
            [['province', 'city', 'district'], 'string', 'max' => 50],
            [['home_image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024 * 2, 'maxFiles' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'user_id'),
            'nik' => Yii::t('app', 'nik'),
            'telp' => Yii::t('app', 'telp'),
            'identity_card_image' => Yii::t('app', 'identity_card_image'),
            'home_image' => Yii::t('app', 'home_image'),
            'birth_place' => Yii::t('app', 'birth_place'),
            'birth_date' => Yii::t('app', 'birth_date'),
            'gender_id' => Yii::t('app', 'gender_id'),
            'education_id' => Yii::t('app', 'education_id'),
            'education_major_id' => Yii::t('app', 'education_major_id'),
            'married_status_id' => Yii::t('app', 'married_status_id'),
            'nationality_id' => Yii::t('app', 'nationality_id'),
            'religion_id' => Yii::t('app', 'religion_id'),
            'residence_status_id' => Yii::t('app', 'residence_status_id'),
            'province' => Yii::t('app', 'province'),
            'city' => Yii::t('app', 'city'),
            'district' => Yii::t('app', 'district'),
            'citizen_association_id' => Yii::t('app', 'citizens_association_id'),
            'neighborhood_association_id' => Yii::t('app', 'neighborhood_association_id'),
            'address' => Yii::t('app', 'address'),
            'family_head_status' => Yii::t('app', 'family_head_status'),
            'dependent_number' => Yii::t('app', 'dependent_number'),
            'interest' => Yii::t('app', 'interest'),
            'registration_date' => Yii::t('app', 'registration_date'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    public function getNationality()
    {
        return $this->hasOne(Nationality::class, ['id' => 'nationality_id']);
    }
}
