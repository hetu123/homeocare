<?php

namespace backend\models;

use common\models\base\MedicineIngredientBase;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MedicineCompositionBaseSearch represents the model behind the search form of `common\models\MedicineCompositionBase`.
 */
class MedicineIngredientSearch extends MedicineIngredientBase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'medicine_id', 'ingredient_id'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = MedicineIngredientBase::find();

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
            'id' => $this->id,
            'medicine_id' => $this->medicine_id,
            'ingredient_id' => $this->ingredient_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
