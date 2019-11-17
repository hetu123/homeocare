<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MedicineImage;

/**
 * MedicineImageSearch represents the model behind the search form of `common\models\MedicineImage`.
 */
class MedicineImageSearch extends MedicineImage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'medicine_id', 'is_cover', 'position', 'visible'], 'integer'],
            [['image', 'image_dimension', 'created_at', 'updated_at'], 'safe'],
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
        $query = MedicineImage::find();

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
            'is_cover' => $this->is_cover,
            'position' => $this->position,
            'visible' => $this->visible,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'image_dimension', $this->image_dimension]);

        return $dataProvider;
    }
    public function search2($id)
    {
        $query = MedicineImage::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where(['medicine_id' => $id]);
        return $dataProvider;
    }
    public function search1($id)
    {
        $query = MedicineImage::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where(['medicine_id' => $id]);
        $query->orderBy('is_cover DESC');
        return $dataProvider;
    }

}
