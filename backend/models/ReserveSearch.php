<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reserve;

/**
 * ReserveSearch represents the model behind the search form about `common\models\Reserve`.
 */
class ReserveSearch extends Reserve
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idreserve', 'idelement', 'idboard', 'quantity'], 'integer'],
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
        $query = Reserve::find();

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
            'idreserve' => $this->idreserve,
            'idelement' => $this->idelement,
            'idboard' => $this->idboard,
            'quantity' => $this->quantity,
        ]);

        return $dataProvider;
    }
}
