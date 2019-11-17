<?php

namespace backend\models;

use common\models\base\MedicineCompositionBase;
use common\models\MedicineComposition;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MedicineCategoryBaseSearch represents the model behind the search form of `common\models\MedicineCategoryBase`.
 */
class MedicineCompositionSearch extends MedicineCompositionBase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'medicine_id', 'composition_id'], 'integer'],
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
        $query = MedicineComposition::find();

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
            'composition_id' => $this->composition_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
