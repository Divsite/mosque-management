<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Charity;

/**
 * CharitySearch represents the model behind the search form of `backend\models\Charity`.
 */
class CharitySearch extends Charity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_charity_id'], 'integer'],
            [['customer_address', 'customer_name', 'customer_number', 'payment_total', 'payment_date', 'timestamp'], 'safe'],
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
        $query = Charity::find();

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
            'type_charity_id' => $this->type_charity_id,
            'payment_date' => $this->payment_date,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'customer_address', $this->customer_address])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_number', $this->customer_number])
            ->andFilterWhere(['like', 'payment_total', $this->payment_total]);

        return $dataProvider;
    }
}
