<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "officer".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $nik
 * @property int|null $nip
 * @property int|null $npwp
 * @property int|null $work_location_id
 * @property int|null $officer_status_id
 * @property int|null $division_id
 * @property int|null $position_id
 * @property float|null $salary
 * @property int|null $bank_id
 * @property int|null $number_account
 * @property int|null $shift_attendance_id
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
 * @property int|null $citizen_association_id
 * @property int|null $neighborhood_association_id
 * @property string|null $address
 * @property string|null $interest
 * @property string|null $registration_date
 * @property int|null $facility_id
 */
class Officer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'officer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'nik', 'nip', 'npwp', 'work_location_id', 'officer_status_id', 'division_id', 'position_id', 'bank_id', 'number_account', 'shift_attendance_id', 'gender_id', 'education_id', 'education_major_id', 'married_status_id', 'nationality_id', 'religion_id', 'residence_status_id', 'citizen_association_id', 'neighborhood_association_id', 'facility_id'], 'integer'],
            [['salary'], 'number'],
            [['birth_date', 'registration_date'], 'safe'],
            [['address'], 'string'],
            [['telp', 'identity_card_image', 'home_image', 'birth_place', 'interest'], 'string', 'max' => 255],
            [['province', 'city', 'district'], 'string', 'max' => 50],
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
            'user_id' => Yii::t('app', 'User ID'),
            'nik' => Yii::t('app', 'Nik'),
            'nip' => Yii::t('app', 'Nip'),
            'npwp' => Yii::t('app', 'Npwp'),
            'work_location_id' => Yii::t('app', 'Work Location ID'),
            'officer_status_id' => Yii::t('app', 'Officer Status ID'),
            'division_id' => Yii::t('app', 'Division ID'),
            'position_id' => Yii::t('app', 'Position ID'),
            'salary' => Yii::t('app', 'Salary'),
            'bank_id' => Yii::t('app', 'Bank ID'),
            'number_account' => Yii::t('app', 'Number Account'),
            'shift_attendance_id' => Yii::t('app', 'Shift Attendance ID'),
            'telp' => Yii::t('app', 'Telp'),
            'identity_card_image' => Yii::t('app', 'Identity Card Image'),
            'home_image' => Yii::t('app', 'Home Image'),
            'birth_place' => Yii::t('app', 'Birth Place'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'gender_id' => Yii::t('app', 'Gender ID'),
            'education_id' => Yii::t('app', 'Education ID'),
            'education_major_id' => Yii::t('app', 'Education Major ID'),
            'married_status_id' => Yii::t('app', 'Married Status ID'),
            'nationality_id' => Yii::t('app', 'Nationality ID'),
            'religion_id' => Yii::t('app', 'Religion ID'),
            'residence_status_id' => Yii::t('app', 'Residence Status ID'),
            'province' => Yii::t('app', 'Province'),
            'city' => Yii::t('app', 'City'),
            'district' => Yii::t('app', 'District'),
            'postcode' => Yii::t('app', 'Postcode'),
            'citizen_association_id' => Yii::t('app', 'Citizen Association ID'),
            'neighborhood_association_id' => Yii::t('app', 'Neighborhood Association ID'),
            'address' => Yii::t('app', 'Address'),
            'interest' => Yii::t('app', 'Interest'),
            'registration_date' => Yii::t('app', 'Registration Date'),
            'facility_id' => Yii::t('app', 'Facility ID'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
