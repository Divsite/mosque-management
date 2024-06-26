<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Receiver;
use Yii;

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
            [['id', 'receiver_type_id', 'receiver_class_id', 'village_id', 'citizens_association_id', 'neighborhood_association_id', 'status'], 'integer'],
            [['desc', 'registration_year', 'barcode_number', 'timestamp', 'status_update', 'clock'], 'safe'],
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
    public function search($params, $receiverType = null)
    {
        $query = Receiver::find()
                ->with('receiverType')
                ->where(['branch_code' => Yii::$app->user->identity->code]);

        if ($receiverType !== null) {
            $query->andWhere(['receiver_type_id' => $receiverType]);
        }

        if (!Yii::$app->user->identity->isSuperadmin()) {
            $query->andWhere(['user_id' => Yii::$app->user->identity->id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ],
            ],
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
            'user_id' => $this->user_id,
            'village_id' => $this->village_id,
            'citizens_association_id' => $this->citizens_association_id,
            'neighborhood_association_id' => $this->neighborhood_association_id,
            'registration_year' => $this->registration_year,
            'status' => $this->status,
            'status_update' => $this->status_update,
            'clock' => $this->clock,
            'timestamp' => $this->timestamp,
        ]);

        // $query
        //     ->andFilterWhere(['like', 'registration_year', $this->registration_year]);

        return $dataProvider;
    }
}
