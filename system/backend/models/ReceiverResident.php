<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_resident".
 *
 * @property int $id
 * @property int|null $receiver_id
 * @property int|null $resident_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class ReceiverResident extends \yii\db\ActiveRecord
{
    const NOT_YET_SHARED = 1;
    const SHARED = 2;
    const NOT_SHARED = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_resident';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['reason'], 'string', 'max' => 255],
            [['receiver_id', 'resident_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'status_update'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'resident_id' => Yii::t('app', 'Resident ID'),
            'reason' => Yii::t('app', 'reason'),
            'status' => Yii::t('app', 'status'),
            'status_update' => Yii::t('app', 'status_update'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getResident()
    {
        return $this->hasOne(Resident::class, ['id' => 'resident_id']);
    }
}
