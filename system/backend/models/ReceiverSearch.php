<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Receiver;

/**
 * ReceiverSearch represents the model behind the search form of `backend\models\Receiver`.
 */
class ReceiverSearch extends Receiver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'receiver_type_id', 'receiver_class_id', 'citizens_association_id', 'neighborhood_association_id', 'qty', 'status'], 'integer'],
            [['name', 'desc', 'registration_year', 'barcode_number', 'timestamp'], 'safe'],
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
        $query = Receiver::find()->with('receiverType');

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
            'receiver_class_id' => $this->receiver_class_id,
            'citizens_association_id' => $this->citizens_association_id,
            'neighborhood_association_id' => $this->neighborhood_association_id,
            'registration_year' => $this->registration_year,
            'qty' => $this->qty,
            'status' => $this->status,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'barcode_number', $this->barcode_number]);

        return $dataProvider;
    }
}
