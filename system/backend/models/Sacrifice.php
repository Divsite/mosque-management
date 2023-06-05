<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sacrifice".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $member
 * @property string|null $timestamp
 */
class Sacrifice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sacrifice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'member'], 'required'],
            [['price'], 'number'],
            [['timestamp'], 'safe'],
            [['name', 'member'], 'string', 'max' => 255],
            // [['member'], 'string', 'max' => 50],
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
            'price' => Yii::t('app', 'Price'),
            'member' => Yii::t('app', 'Member'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
