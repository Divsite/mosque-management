<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "neighborhood_association".
 *
 * @property int $id
 * @property int $citizens_association_id
 * @property string $name
 * @property string $responsible
 * @property string $telp
 * @property string|null $timestamp
 */
class NeighborhoodAssociation extends \yii\db\ActiveRecord
{
    const RT1 = 1;
    const RT2 = 2;
    const RT3 = 3;
    const RT4 = 4;
    const RT5 = 5;
    const RT6 = 6;
    const PNT = 7;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'neighborhood_association';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['citizens_association_id', 'name', 'responsible', 'telp'], 'required'],
            [['citizens_association_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['name', 'responsible', 'telp', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'citizens_association_id' => Yii::t('app', 'Citizens Association ID'),
            'name' => Yii::t('app', 'Name'),
            'responsible' => Yii::t('app', 'Responsible'),
            'telp' => Yii::t('app', 'Telp'),
            'color' => Yii::t('app', 'Color'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public function getManyReceiver()
    {
        return $this->hasMany(Receiver::class, ['neighborhood_association_id' => 'id']);
    }
}
