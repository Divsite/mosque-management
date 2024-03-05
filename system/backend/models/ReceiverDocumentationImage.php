<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_documentation_image".
 *
 * @property int $id
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
class ReceiverDocumentationImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_documentation_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['receiver_id'], 'required'],
            [['receiver_id', 'size', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['name', 'type', 'extension'], 'string', 'max' => 255],
            [['url'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024 * 2, 'maxFiles' => 3]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_id' => Yii::t('app', 'receiver_id'),
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
