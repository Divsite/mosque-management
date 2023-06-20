<?php

namespace backend\models;

use Yii;
use backend\models\ReceiverType;
use backend\models\ReceiverClass;
use backend\models\User;
use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use yii\helpers\Html;

/**
 * This is the model class for table "receiver".
 *
 * @property int $id
 * @property int $receiver_type_id
 * @property int|null $receiver_class_id
 * @property string|null $name
 * @property string|null $desc
 * @property int|null $citizens_association_id
 * @property int|null $neighborhood_association_id
 * @property string|null $registration_year
 * @property string|null $barcode_number
 * @property int|null $status
 * @property string|null $timestamp
 */
class Receiver extends \yii\db\ActiveRecord
{
    const NOT_CLAIM = 1;
    const CLAIM = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_type_id', 'citizens_association_id', 'neighborhood_association_id'], 'required'],
            [['receiver_type_id', 'receiver_class_id', 'user_id', 'citizens_association_id', 'neighborhood_association_id', 'status', 'resident_id'], 'integer'],
            [['desc'], 'string'],
            [['registration_year', 'status_update', 'timestamp'], 'safe'],
            [['barcode_number'], 'string', 'max' => 255],
            [['branch_code'], 'string', 'max' => 50],
            ['status_update', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['clock', 'time', 'format' => 'php:H:i', 'message' => 'Invalid time format.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_type_id' => Yii::t('app', 'receiver_type_id'),
            'receiver_class_id' => Yii::t('app', 'receiver_class_id'),
            'name' => Yii::t('app', 'receiver_name'),
            'desc' => Yii::t('app', 'receiver_desc'),
            'citizens_association_id' => Yii::t('app', 'citizens_association_id'),
            'neighborhood_association_id' => Yii::t('app', 'neighborhood_association_id'),
            'registration_year' => Yii::t('app', 'registration_year'),
            'barcode_number' => Yii::t('app', 'barcode_number'),
            'status' => Yii::t('app', 'status'),
            'status_update' => Yii::t('app', 'status_update'),
            'clock' => Yii::t('app', 'clock'),
            'user_id' => Yii::t('app', 'user_id'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'resident_id' => Yii::t('app', 'resident_id'),
            'timestamp' => Yii::t('app', 'timestamp'),
        ];
    }

    public function getReceiverType()
    {
        return $this->hasOne(ReceiverType::class, ['id' => 'receiver_type_id']);
    }
    
    public function getReceiverClass()
    {
        return $this->hasOne(ReceiverClass::class, ['id' => 'receiver_class_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    public function getCitizens()
    {
        return $this->hasOne(CitizensAssociation::class, ['id' => 'citizens_association_id']);
    }
    
    public function getNeighborhood()
    {
        return $this->hasOne(NeighborhoodAssociation::class, ['id' => 'neighborhood_association_id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['code' => 'branch_code']);
    }

    public function generateRunningNumberByBranchAndType($receiverType, $branch)
    {
        $queryBarcode = Receiver::find()
                ->where(['receiver_type_id' => $receiverType->id])
                ->andWhere(['branch_code' => $branch->code])
                ->count() + 1;

        $code_digit  = 3;

        if ($queryBarcode == null) {
            return str_pad($this->id . 1 , $code_digit, '0', STR_PAD_LEFT);
        } else {
            $running_number = str_pad($queryBarcode, $code_digit, '0', STR_PAD_LEFT);
            return $running_number;
        }
    }

    public function getStatus()
    {
        $status = null;

        $actionStatus = null;

        if ($actionStatus){
            $data = $actionStatus;
        } else{
            $data = $this->status;
        }

        if ($data == Receiver::NOT_CLAIM){
            $status = Html::a(Yii::t('app', 'not_claimed'), null, ['class' => 'btn btn-danger btn-sm disable', 'style' => 'color:white']);
        }
        elseif ($data == Receiver::CLAIM) {
            $status = Html::a(Yii::t('app', 'already_claimed'), null, ['class' => 'btn btn-secondary btn-sm disable', 'style' => 'color:white']);
        }

        return $status;
    }
    
    public static function getClaimStatusCouponByBranch() : int 
    {
        return static::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                    'status' => Receiver::CLAIM
                ])
                ->count();
    }
    
    public static function getNotClaimStatusCouponByBranch() : int 
    {
        return static::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                    'status' => Receiver::NOT_CLAIM
                ])
                ->count();
    }
    
    public static function getTotalCouponByBranch() : int 
    {
        return static::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                ])
                ->count();
    }
}
