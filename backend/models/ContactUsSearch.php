<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ContactUs;

/**
 * ContactUsSearch represents the model behind the search form of `common\models\ContactUs`.
 */
class ContactUsSearch extends ContactUs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'email', 'contact_number', 'support_and_inquiries', 'complains', 'tracking_and_delivery', 'whats_app'], 'integer'],
            [['location', 'created_at', 'updated_at'], 'safe'],
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
        $query = ContactUs::find();

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
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'support_and_inquiries' => $this->support_and_inquiries,
            'complains' => $this->complains,
            'tracking_and_delivery' => $this->tracking_and_delivery,
            'whats_app' => $this->whats_app,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
