<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Medicines;

/**
 * MedicinesSearch represents the model behind the search form of `common\models\Medicines`.
 */
class MedicinesSearch extends Medicines
{
    public $category_id,$type_id,$brand_id,$composition_id,$ingredient_id,$packing_id,$condition_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'total_stock', 'total_gst', 'use_stock', 'left_stock', 'is_active', 'MRP'], 'integer'],
            [['code', 'name', 'gujrati_name', 'hindi_name', 'description', 'gujrati_description', 'hindi_description', 'dosages', 'solution_for', 'direction', 'indications', 'tags', 'gujrati_tags', 'hindi_tags', 'manufacture_date', 'expiry_date', 'created_at', 'updated_at'], 'safe'],
            [['price', 'discount_in_amount', 'discount_in_percentage'], 'number'],
            [[  'category_id','type_id','brand_id','composition_id','ingredient_id','packing_id' ,'condition_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Medicines::find()->alias('m');

        $query->joinWith('medicineCategories');//join the table
        $query->joinWith('medicineBrands');
        $query->joinWith('medicineCompositions');
        $query->joinWith('medicineConditions');
        $query->joinWith('medicineIngredients');
        $query->joinWith('medicineTypes');
        $query->joinWith('medicinePackings');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'm.id' => $this->id,
            'language_id' => $this->language_id,
            'total_stock' => $this->total_stock,
            'total_gst' => $this->total_gst,
            'use_stock' => $this->use_stock,
            'left_stock' => $this->left_stock,
            'is_active' => $this->is_active,
            'manufacture_date' => $this->manufacture_date,
            'expiry_date' => $this->expiry_date,
            'price' => $this->price,
            'discount_in_amount' => $this->discount_in_amount,
            'discount_in_percentage' => $this->discount_in_percentage,
            'MRP' => $this->MRP,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'gujrati_name', $this->gujrati_name])
            ->andFilterWhere(['like', 'hindi_name', $this->hindi_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'gujrati_description', $this->gujrati_description])
            ->andFilterWhere(['like', 'hindi_description', $this->hindi_description])
            ->andFilterWhere(['like', 'dosages', $this->dosages])
            ->andFilterWhere(['like', 'solution_for', $this->solution_for])
            ->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'indications', $this->indications])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'gujrati_tags', $this->gujrati_tags])
            ->andFilterWhere(['like', 'hindi_tags', $this->hindi_tags])
            ->andFilterWhere(['like','medicine_category.category_id',$this->category_id])
            ->andFilterWhere(['like','medicine_brand.brand_id',$this->brand_id])
            ->andFilterWhere(['like','medicine_composition.composition_id',$this->composition_id])
            ->andFilterWhere(['like','medicine_conditions.condition_id',$this->condition_id])
            ->andFilterWhere(['like','medicine_ingredient.ingredient_id',$this->ingredient_id])
            ->andFilterWhere(['like','medicine_type.type_id',$this->type_id])
            ->andFilterWhere(['like','medicine_packing.packing_id',$this->packing_id]);
        return $dataProvider;
    }
}
