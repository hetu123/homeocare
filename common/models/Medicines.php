<?php

namespace common\models;

use yii\db\Query;
use yii\helpers\ArrayHelper;


class Medicines extends \common\models\base\MedicinesBase
{
    const IS_ACTIVE = 1;
    const IS_DELETED = 0;

    public $category_id,$type_id,$brand_id,$composition_id,$ingredient_id,$packing_id,$condition_id;

    private $_category,$_type,$_brand,$_composition,$_ingredient,$_packing,$_conditions;

    public function getSelectedCategory()
    {
        if ($this->_category === null) {
            $this->_category = MedicineCategory::find()->where(['category_id' => $this->category_id]);
        }
        return $this->_category;
    }
    public function getSelectedType()
    {
        if ($this->_type === null) {
            $this->_type = MedicineType::find()->where(['type_id' => $this->type_id]);
        }
        return $this->_type;
    }
    public function getSelectedBrand()
    {
        if ($this->_brand === null) {
            $this->_brand = MedicineBrand::find()->where(['brand_id' => $this->brand_id]);
        }
        return $this->_brand;
    }
    public function getSelectedComposition()
    {
        if ($this->_composition === null) {
            $this->_composition = MedicineComposition::find()->where(['composition_id' => $this->composition_id]);
        }
        return $this->_composition;
    }
    public function getSelectedIngredient()
    {
        if ($this->_ingredient === null) {
            $this->_ingredient = MedicineIngredient::find()->where(['ingredient_id' => $this->ingredient_id]);
        }
        return $this->_ingredient;
    }
    public function getSelectedPacking()
    {
        if ($this->_packing === null) {
            $this->_packing = MedicinesPacking::find()->where(['packing_id' => $this->packing_id]);
        }
        return $this->_packing;
    }

    public function getSelectedCondition()
    {
        if ($this->_conditions === null) {
                $this->_conditions = MedicineConditions::find()->where(['condition_id' => $this->condition_id]);
        }
        return $this->_conditions;
    }
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[

            'category_id' => 'Categories',
            'type_id' => 'Types',
            'brand_id'=>'Company Name',
            'composition_id'=>'Compositions',
            'ingredient_id'=>'Ingredients',
            'packing_id' => 'Packings',
            'condition_id'=>'Conditions',
        ]);
    }
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),[
            [['category_id','type_id','brand_id','composition_id','ingredient_id','packing_id','condition_id'], 'safe'],
        ]);
    }

    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findWithRelations($language_id){
        $findQuery = self::findWith($language_id);
       /* $placeId = (new Query())
            ->select('min(id)')
            ->from(MerchantPlaces::tableName())
            ->where('merchant_id = d.merchant_id');
        $findQuery->andWhere(['mp.id' => $placeId]);*/
        $findQuery->with('medicineBrands.brand');
        $findQuery->with('medicineCompositions.composition');
        $findQuery->with('medicineImages');
        $findQuery->with('medicineIngredients.ingredient');
        $findQuery->with('medicineCategories.category');
        $findQuery->with('medicinePackings.packing');
        $findQuery->with('medicineTypes.type');
        return $findQuery;
    }

    public static function findWith($language_id = null){
        if ($language_id == null) {
            $language_id = '1';
        }
        $findQuery = parent::find();
        $findQuery->alias('m');
           //     $findQuery->where(['m.language_id' => $language_id]);
        //TODO : Need to remove category table for removing duplication of deals data
        $coverMax = (new Query())
            ->select('max(id)')
            ->from(MedicineImage::tableName())
            ->where('medicine_id = m.id')
            ->andWhere('is_cover=1');
        $coverImage = (new Query())
            ->select('image')
            ->from(MedicineImage::tableName())
            ->where(['id' => $coverMax]);
        $defaultMax = (new Query())
            ->select('min(id)')
            ->from(MedicineImage::tableName())
            ->where('medicine_id = m.id');
        $languageCode = (new Query())
            ->select('code')
            ->from(Language::tableName())
            ->where(['id'=>$language_id])->one();
        $defaultImage = (new Query())
            ->select('image')
            ->from(MedicineImage::tableName())
            ->where(['id' => $defaultMax]);
       
        $findQuery->select(['m.id']);
        if($languageCode['code'] === 'GU'){
            $findQuery->addSelect(['m.gujrati_name as name','m.gujrati_description as description']);
        }
        elseif ($languageCode['code'] === 'HN'){
            $findQuery->addSelect(['m.hindi_name as description','m.hindi_description as description']);
        }
        else{
           $findQuery->addSelect(['m.name', 'm.description',]);
        }
        $findQuery->addSelect(['m.dosages', 'm.solution_for', 'm.direction', 'm.indications',
            'm.manufacture_date', 'm.expiry_date', 'm.price','m.discount_in_amount','m.discount_in_percentage', 'm.MRP as strike_price']);
        $findQuery->addSelect(['cover_image'=>$coverImage]);
        $findQuery->addSelect(['default_image'=>$defaultImage]);
        $findQuery->addSelect(['sgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);
        $findQuery->addSelect(['cgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);
        $findQuery->andWhere(['m.is_active' => Medicines::IS_ACTIVE]);
        $date = date('Y-m-d H:i:s');
       // $findQuery->andWhere('m.expiry_date > "' . $date . '"OR m.expiry_date is null');
        //$findQuery->orderBy(['name'=>SORT_ASC]);
        $findQuery->asArray();

        return $findQuery; // TODO: Change the autogenerated stub
    }
    public static function updateStock($id,$quantity)
    {
        $objMedicine = Medicines::findByPk($id);
        $objMedicine->use_stock += $quantity;
        $objMedicine->left_stock -= $quantity;
        $result=$objMedicine->save(false);
        return $result;
    }



}
