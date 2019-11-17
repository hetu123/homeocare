<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppoinmentBooking;

/**
 * AppoinmentBookingSearch represents the model behind the search form of `common\models\AppoinmentBooking`.
 */
class AppoinmentBookingSearch extends AppoinmentBooking
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'age_group_id', 'time_slot_id', 'is_approve', 'is_cancel'], 'integer'],
            [['date', 'symptoms', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = AppoinmentBooking::find();

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
            'age_group_id' => $this->age_group_id,
            'date' => $this->date,
            'time_slot_id' => $this->time_slot_id,
            'is_approve' => $this->is_approve,
            'is_cancel' => $this->is_cancel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'symptoms', $this->symptoms])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
