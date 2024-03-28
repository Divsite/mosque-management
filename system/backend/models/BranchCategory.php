<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "branch_category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $timestamp
 */
class BranchCategory extends \yii\db\ActiveRecord
{
    const MOSQUE = 3;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => Yii::t('app', 'Name'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    public static function getListBranchCategory()
    {
        return ArrayHelper::map(
            static::find()->all(), 'id', 'name'
        );
    }
}
