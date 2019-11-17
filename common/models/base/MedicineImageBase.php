<?php

namespace common\models\base;

use Yii;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_image".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property string $image
    * @property string $image_dimension
    * @property integer $is_cover
    * @property integer $position
    * @property integer $visible
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Medicines $medicine
    */
class MedicineImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id'], 'required'],
            [['medicine_id', 'is_cover', 'position', 'visible'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'image_dimension'], 'string', 'max' => 255],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'medicine_id' => 'Medicine ID',
    'image' => 'Image',
    'image_dimension' => 'Image Dimension',
    'is_cover' => 'Is Cover',
    'position' => 'Position',
    'visible' => 'Visible',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}