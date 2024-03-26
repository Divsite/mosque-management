<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReceiverClass;
use Yii;

/**
 * ReceiverClassSearch represents the model behind the search form of `backend\models\ReceiverClass`.
 */
class ReceiverClassSearch extends ReceiverClass
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'get_rice', 'is_active', 'receiver_class_source_id'], 'integer'],
            [['timestamp', 'registration_year'], 'safe'],
            [['get_money'], 'number'],
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
        $query = ReceiverClass::find()->where(['branch_code' => Yii::$app->user->identity->code]);

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
            'receiver_class_source_id' => $this->receiver_class_source_id,
            'get_money' => $this->get_money,
            'get_rice' => $this->get_rice,
            'timestamp' => $this->timestamp,
            'registration_year' => $this->registration_year,
            'is_active' => $this->is_active,
        ]);

        return $dataProvider;
    }
}
