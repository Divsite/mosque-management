<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Resident;

/**
 * ResidentSearch represents the model behind the search form of `backend\models\Resident`.
 */
class ResidentSearch extends Resident
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nik', 'gender_id', 'education_id', 'education_major_id', 'married_status_id', 'nationality_id', 'religion_id', 'residence_status_id', 'citizen_association_id', 'neighborhood_association_id', 'family_head_status', 'dependent_number'], 'integer'],
            [['user_id', 'telp', 'identity_card_image', 'home_image', 'birth_place', 'birth_date', 'province', 'city', 'district', 'postcode', 'address', 'interest', 'registration_date'], 'safe'],
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
        $query = Resident::find();

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
            'birth_date' => $this->birth_date,
            'gender_id' => $this->gender_id,
            'education_id' => $this->education_id,
            'education_major_id' => $this->education_major_id,
            'married_status_id' => $this->married_status_id,
            'nationality_id' => $this->nationality_id,
            'religion_id' => $this->religion_id,
            'residence_status_id' => $this->residence_status_id,
            'citizen_association_id' => $this->citizen_association_id,
            'neighborhood_association_id' => $this->neighborhood_association_id,
            'family_head_status' => $this->family_head_status,
            'dependent_number' => $this->dependent_number,
            'registration_date' => $this->registration_date,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'identity_card_image', $this->identity_card_image])
            ->andFilterWhere(['like', 'home_image', $this->home_image])
            ->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'interest', $this->interest]);

        return $dataProvider;
    }
}
