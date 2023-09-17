<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Charity;
use Yii;

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
            [['id', 'type_charity_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['year', 'branch_code', 'created_at', 'updated_at', 'timestamp'], 'safe'],
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
        $user = Yii::$app->user->identity;

        if ($user->isSuperadmin()) 
        {
            $query = Charity::find()
                    ->with('charityType');
        } else {
            $query = Charity::find()
                    ->with('charityType')
                    ->where(['branch_code' => Yii::$app->user->identity->code]);
        }

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
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'year' => $this->year,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'branch_code', $this->branch_code]);

        return $dataProvider;
    }
}
