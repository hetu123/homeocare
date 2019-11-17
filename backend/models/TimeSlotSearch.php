<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TimeSlot;

/**
 * TimeSlotSearch represents the model behind the search form of `common\models\TimeSlot`.
 */
class TimeSlotSearch extends TimeSlot
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_open'], 'integer'],
            [['day', 'morning_hours_from', 'morning_hours_to', 'evening_hours_from', 'evening_hours_to', 'created_at', 'updated_at'], 'safe'],
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
        $query = TimeSlot::find();

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
            'is_open' => $this->is_open,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'day', $this->day])
            ->andFilterWhere(['like', 'morning_hours_from', $this->morning_hours_from])
            ->andFilterWhere(['like', 'morning_hours_to', $this->morning_hours_to])
            ->andFilterWhere(['like', 'evening_hours_from', $this->evening_hours_from])
            ->andFilterWhere(['like', 'evening_hours_to', $this->evening_hours_to]);

        return $dataProvider;
    }
}
