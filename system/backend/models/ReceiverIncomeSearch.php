<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReceiverIncome;

/**
 * ReceiverIncomeSearch represents the model behind the search form of `backend\models\ReceiverIncome`.
 */
class ReceiverIncomeSearch extends ReceiverIncome
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'receiver_income_type_id', 'receiver_type_id', 'created_by', 'updated_by'], 'integer'],
            [['branch_code', 'registration_year', 'description', 'created_at', 'updated_at', 'timestamp'], 'safe'],
            [['amount_money', 'amount_rice'], 'number'],
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
        $query = ReceiverIncome::find();

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
            'receiver_type_id' => $this->receiver_type_id,
            'receiver_income_type_id' => $this->receiver_income_type_id,
            'registration_year' => $this->registration_year,
            'amount_money' => $this->amount_money,
            'amount_rice' => $this->amount_rice,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'branch_code', $this->branch_code])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
