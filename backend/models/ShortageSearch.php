<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shortage;

/**
 * ShortageSearch represents the model behind the search form about `app\models\Shortage`.
 */
class ShortageSearch extends Shortage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idboard', 'idelement', 'quantity'], 'integer'],
            [['ref_of', 'date'], 'safe'],
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
        $query = Shortage::find();

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
            'idboard' => $this->idboard,
            'idelement' => $this->idelement,
            'quantity' => $this->quantity,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'ref_of', $this->ref_of]);

        return $dataProvider;
    }
}
