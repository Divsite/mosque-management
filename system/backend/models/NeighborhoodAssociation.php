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
            [['name', 'responsible', 'telp'], 'string', 'max' => 255],
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
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
