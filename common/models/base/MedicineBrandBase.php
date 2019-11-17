<?php

namespace common\models\base;

use Yii;
use common\models\Brand;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_brand".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $brand_id
    * @property string $created_at
    *
            * @property Brand $brand
            * @property Medicines $medicine
    */
class MedicineBrandBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_brand';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'brand_id'], 'required'],
            [['medicine_id', 'brand_id'], 'integer'],
            [['created_at'], 'safe'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
    'brand_id' => 'Brand',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBrand()
    {
    return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}
