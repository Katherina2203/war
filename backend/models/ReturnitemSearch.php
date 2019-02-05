<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Returnitem;

/**
 * ReturnitemSearch represents the model behind the search form about `common\models\Returnitem`.
 */
class ReturnitemSearch extends Returnitem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idreturn', 'idelement', 'quantity', 'created_by', 'updated_by'], 'integer'],
           // [['date_return'], 'safe'],
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
        $query = Returnitem::find()->with(['elements']);

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
            'idreturn' => $this->idreturn,
            'idelement' => $this->idelement,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
