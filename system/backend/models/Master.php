<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "master".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $url
 * @property string|null $timestamp
 */
class Master extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'url'], 'required'],
            [['timestamp'], 'safe'],
            [['name', 'slug', 'url'], 'string', 'max' => 50],
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
            'slug' => Yii::t('app', 'Slug'),
            'url' => Yii::t('app', 'Url'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
