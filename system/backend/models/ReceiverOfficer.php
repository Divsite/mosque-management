<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_officer".
 *
 * @property int $id
 * @property int|null $receiver_id
 * @property int|null $officer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class ReceiverOfficer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_officer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_id', 'officer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'officer_id' => Yii::t('app', 'Officer ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getOfficer()
    {
        return $this->hasOne(Officer::class, ['id' => 'officer_id']);
    }
}
