<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReceiverExpense;
use Yii;

/**
 * ReceiverOperationalTypeSearch represents the model behind the search form of `backend\models\ReceiverOperationalType`.
 */
class ReceiverExpenseSearch extends ReceiverExpense
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'receiver_type_id', 'amount', 'created_by', 'updated_by'], 'integer'],
            [['description', 'branch_code', 'receiver_operational_code', 'registration_year', 'created_at', 'updated_at', 'timestamp'], 'safe'],
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
        if (Yii::$app->user->identity->type == UserType::DIVSITE) 
        { // superadmin
            $query = ReceiverExpense::find()
                    ->with('operationalType');
        } else {
            $query = ReceiverExpense::find()
                    ->with('operationalType')
                    ->where(['branch_code' => Yii::$app->user->identity->code])
                    ->andWhere(['created_by' => Yii::$app->user->identity->id]);
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
            'receiver_type_id' => $this->receiver_type_id,
            'amount' => $this->amount,
            'registration_year' => $this->registration_year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'branch_code', $this->branch_code])
            ->andFilterWhere(['like', 'receiver_operational_code', $this->receiver_operational_code]);

        return $dataProvider;
    }
}
