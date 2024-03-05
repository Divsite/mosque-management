<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EnvMember;

/**
 * EnvMemberSearch represents the model behind the search form of `backend\models\EnvMember`.
 */
class EnvMemberSearch extends EnvMember
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'env_id', 'env_division_id', 'is_chief'], 'integer'],
            [['name', 'timestamp'], 'safe'],
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
        $query = EnvMember::find();

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
            'env_id' => $this->env_id,
            'env_division_id' => $this->env_division_id,
            'is_chief' => $this->is_chief,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
