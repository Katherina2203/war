<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Values;

/**
 * ValuesSearch represents the model behind the search form about `common\models\Values`.
 */
class ValuesSearch extends Values
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'idattribute'], 'integer'],
            [['significance'], 'safe'],
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
        $query = Values::find();

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
            'idelement' => $this->idelement,
            'idattribute' => $this->idattribute,
        ]);

        $query->andFilterWhere(['like', 'significance', $this->significance]);

        return $dataProvider;
    }
}
