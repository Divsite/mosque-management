<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_class".
 *
 * @property int $id
 * @property string $name
 * @property float|null $get_money
 * @property int|null $get_rice
 * @property string|null $timestamp
 */
class ReceiverClass extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const NONACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_code', 'name'], 'required'],
            [['get_money'], 'number'],
            [['get_rice', 'is_active'], 'integer'],
            [['branch_code'], 'string', 'max' => 50],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'branch_code' => Yii::t('app', 'branch_code'),
            'get_money' => Yii::t('app', 'Get Money'),
            'get_rice' => Yii::t('app', 'Get Rice'),
            'is_active' => Yii::t('app', 'is_active'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
