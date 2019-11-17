<?php

namespace common\models\base;

use common\models\MedicinesPacking;
use Yii;
use common\models\Cart;
use common\models\MedicineBrand;
use common\models\MedicineCategory;
use common\models\MedicineComposition;
use common\models\MedicineConditions;
use common\models\MedicineImage;
use common\models\MedicineIngredient;
use common\models\MedicineMaster;
use common\models\MedicinePacking;
use common\models\MedicineType;
use common\models\Language;
use common\models\Wishlist;

/**
 * This is the model class for table "medicines".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $code
    * @property string $name
    * @property string $gujrati_name
    * @property string $hindi_name
    * @property string $description
    * @property string $gujrati_description
    * @property string $hindi_description
    * @property string $dosages
    * @property string $solution_for
    * @property string $direction
    * @property string $indications
    * @property string $tags
    * @property string $gujrati_tags
    * @property string $hindi_tags
    * @property integer $total_stock
    * @property integer $total_gst
    * @property integer $use_stock
    * @property integer $left_stock
    * @property integer $is_active
    * @property string $manufacture_date
    * @property string $expiry_date
    * @property double $price
    * @property double $discount_in_amount
    * @property double $discount_in_percentage
    * @property integer $MRP
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Cart[] $carts
            * @property MedicineBrand[] $medicineBrands
            * @property MedicineCategory[] $medicineCategories
            * @property MedicineComposition[] $medicineCompositions
            * @property MedicineConditions[] $medicineConditions
            * @property MedicineImage[] $medicineImages
            * @property MedicineIngredient[] $medicineIngredients
            * @property MedicineMaster[] $medicineMasters
            * @property MedicinePacking[] $medicinePackings
            * @property MedicineType[] $medicineTypes
            * @property Language $language
            * @property Wishlist[] $wishlists
    */
class MedicinesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicines';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'total_stock', 'total_gst', 'use_stock', 'left_stock', 'is_active', 'MRP'], 'integer'],
            [['name', 'MRP'], 'required'],
            [['description', 'gujrati_description', 'hindi_description', 'dosages', 'solution_for', 'direction', 'indications', 'tags', 'gujrati_tags', 'hindi_tags'], 'string'],
            [['manufacture_date', 'expiry_date', 'created_at', 'updated_at'], 'safe'],
            [['price', 'discount_in_amount', 'discount_in_percentage'], 'number'],
            [['code', 'name', 'gujrati_name', 'hindi_name'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'language_id' => 'Language ID',
    'code' => 'Code',
    'name' => 'Name',
    'gujrati_name' => 'Gujrati Name',
    'hindi_name' => 'Hindi Name',
    'description' => 'Description',
    'gujrati_description' => 'Gujrati Description',
    'hindi_description' => 'Hindi Description',
    'dosages' => 'Dosages',
    'solution_for' => 'Solution For',
    'direction' => 'Direction',
    'indications' => 'Indications',
    'tags' => 'Tags',
    'gujrati_tags' => 'Gujrati Tags',
    'hindi_tags' => 'Hindi Tags',
    'total_stock' => 'Total Stock',
    'total_gst' => 'Total Gst',
    'use_stock' => 'Use Stock',
    'left_stock' => 'Left Stock',
    'is_active' => 'Is Active',
    'manufacture_date' => 'Manufacture Date',
    'expiry_date' => 'Expiry Date',
    'price' => 'Price',
    'discount_in_amount' => 'Discount In Amount',
    'discount_in_percentage' => 'Discount In Percentage',
    'MRP' => 'Mrp',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCarts()
    {
    return $this->hasMany(Cart::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineBrands()
    {
    return $this->hasMany(MedicineBrand::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineCategories()
    {
    return $this->hasMany(MedicineCategory::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineCompositions()
    {
    return $this->hasMany(MedicineComposition::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineConditions()
    {
    return $this->hasMany(MedicineConditions::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineImages()
    {
    return $this->hasMany(MedicineImage::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineIngredients()
    {
    return $this->hasMany(MedicineIngredient::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineMasters()
    {
    return $this->hasMany(MedicineMaster::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicinePackings()
    {
    return $this->hasMany(MedicinesPacking::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineTypes()
    {
    return $this->hasMany(MedicineType::className(), ['medicine_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWishlists()
    {
    return $this->hasMany(Wishlist::className(), ['medicine_id' => 'id']);
    }
}