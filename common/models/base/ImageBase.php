<?php

namespace common\models\base;

use Yii;
use common\models\BlogImage;
use common\models\MedicineImage;

/**
 * This is the model class for table "image".
*
    * @property integer $id
    * @property string $image
    * @property string $type
    * @property string $created_at
    * @property string $updated_at
    *
            * @property BlogImage[] $blogImages
            * @property MedicineImage[] $medicineImages
    */
class ImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['image', 'type'], 'required'],
            [['type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'image' => 'Image',
    'type' => 'Type',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBlogImages()
    {
    return $this->hasMany(BlogImage::className(), ['image_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineImages()
    {
    return $this->hasMany(MedicineImage::className(), ['image_id' => 'id']);
    }
}