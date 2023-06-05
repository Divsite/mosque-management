<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\NeighborhoodAssociation;

/**
 * NeighborhoodAssociationSearch represents the model behind the search form of `backend\models\NeighborhoodAssociation`.
 */
class NeighborhoodAssociationSearch extends NeighborhoodAssociation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'citizens_association_id'], 'integer'],
            [['name', 'responsible', 'telp', 'timestamp'], 'safe'],
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
        $query = NeighborhoodAssociation::find();

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
            'citizens_association_id' => $this->citizens_association_id,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'responsible', $this->responsible])
            ->andFilterWhere(['like', 'telp', $this->telp]);

        return $dataProvider;
    }
}
