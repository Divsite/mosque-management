<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "env_member".
 *
 * @property int $id
 * @property int $env_id
 * @property int $env_division_id
 * @property string|null $name
 * @property int|null $is_chief
 * @property string|null $timestamp
 */
class EnvMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'env_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['env_id', 'env_division_id'], 'required'],
            [['env_id', 'env_division_id', 'is_chief'], 'integer'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'env_id' => Yii::t('app', 'Env ID'),
            'env_division_id' => Yii::t('app', 'Env Division ID'),
            'name' => Yii::t('app', 'Name'),
            'is_chief' => Yii::t('app', 'Is Chief'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
