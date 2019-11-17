<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cart;

/**
 * CartSearch represents the model behind the search form of `common\models\Cart`.
 */
class CartSearch extends Cart
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'medicine_id', 'discount', 'quantity'], 'integer'],
            [['anonymous_identifier', 'created_at', 'updated_at'], 'safe'],
            [['store_price', 'total_price', 'paid_price'], 'number'],
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
        $query = Cart::find();

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
            'user_id' => $this->user_id,
            'medicine_id' => $this->medicine_id,
            'store_price' => $this->store_price,
            'discount' => $this->discount,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'paid_price' => $this->paid_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'anonymous_identifier', $this->anonymous_identifier]);

        return $dataProvider;
    }
}
