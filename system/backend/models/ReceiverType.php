<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "receiver_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $timestamp
 */
class ReceiverType extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const NONACTIVE = 0;

    const ZAKAT = 1;
    const SACRIFICE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_code'], 'required'],
            [['is_active'], 'integer'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code', 'branch_code'], 'string', 'max' => 50],
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
            'code' => Yii::t('app', 'code'),
            'branch_code' => Yii::t('app', 'branch_code'),
            'is_active' => Yii::t('app', 'is_active'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public static function getListReceiverType()
    {
        return ArrayHelper::map(
            static::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code, 
                    'is_active' => self::ACTIVE,
                ])->all(), 'id', 'name'
        );
    }
}
