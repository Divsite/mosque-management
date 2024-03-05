<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "resident_documentation_image".
 *
 * @property int $id
 * @property int $resident_id
 * @property string|null $name
 * @property string|null $type
 * @property int|null $size
 * @property string|null $extension
 * @property string|null $url
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $description
 */
class ResidentDocumentationImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resident_documentation_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resident_id'], 'required'],
            [['resident_id', 'size', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['name', 'type', 'extension', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'resident_id' => Yii::t('app', 'Resident ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'extension' => Yii::t('app', 'Extension'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
