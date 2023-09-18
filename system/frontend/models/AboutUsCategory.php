<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "about_us_category".
 *
 * @property int $id
 * @property string|null $branch_code
 * @property string $name
 * @property string $timestamp
 */
class AboutUsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_us_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'timestamp'], 'required'],
            [['timestamp'], 'safe'],
            [['branch_code'], 'string', 'max' => 50],
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
            'branch_code' => Yii::t('app', 'Branch Code'),
            'name' => Yii::t('app', 'Name'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
