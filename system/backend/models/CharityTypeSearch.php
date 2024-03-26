<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CharityType;
use Yii;

/**
 * CharityTypeSearch represents the model behind the search form of `backend\models\CharityType`.
 */
class CharityTypeSearch extends CharityType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_active', 'charity_type_source_id'], 'integer'],
            [['desc', 'timestamp', 'registration_year'], 'safe'],
            [['min', 'max', 'total_rice'], 'number'],
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
        $query = CharityType::find()->where(['branch_code' => Yii::$app->user->identity->code]);

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
            'charity_type_source_id' => $this->charity_type_source_id,
            'min' => $this->min,
            'max' => $this->max,
            'total_rice' => $this->total_rice,
            'timestamp' => $this->timestamp,
            'registration_year' => $this->registration_year,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
