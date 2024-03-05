<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Env;

/**
 * EnvSearch represents the model behind the search form of `backend\models\Env`.
 */
class EnvSearch extends Env
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nik', 'citizen_association_id', 'neighborhood_association_id', 'village_id'], 'integer'],
            [['user_id', 'province', 'city', 'district', 'telp', 'periode', 'registration_date'], 'safe'],
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
        $query = Env::find();

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
            'nik' => $this->nik,
            'citizen_association_id' => $this->citizen_association_id,
            'neighborhood_association_id' => $this->neighborhood_association_id,
            'village_id' => $this->village_id,
            'registration_date' => $this->registration_date,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'periode', $this->periode]);

        return $dataProvider;
    }
}
