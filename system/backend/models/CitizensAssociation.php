<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "citizens_association".
 *
 * @property int $id
 * @property string $name
 * @property string $lead
 * @property string $telp
 * @property string|null $timestamp
 */
class CitizensAssociation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citizens_association';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lead', 'telp'], 'required'],
            [['timestamp'], 'safe'],
            [['name', 'lead', 'telp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'lead' => Yii::t('app', 'Lead'),
            'telp' => Yii::t('app', 'Telp'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
