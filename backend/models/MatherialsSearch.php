<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Matherials;

/**
 * MatherialsSearch represents the model behind the search form about `common\models\Matherials`.
 */
class MatherialsSearch extends Matherials
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idmatherial'], 'integer'],
            [['storeplace', 'name', 'description', 'date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Matherials::find();

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
            'idmatherial' => $this->idmatherial,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'storeplace', $this->storeplace])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
