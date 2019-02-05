<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Elements;

/**
 * elementsSearch represents the model behind the search form about `common\models\Elements`.
 */
class elementsSearch extends Elements
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelements', 'quantity', 'idproduce', 'idcategory'], 'integer'],
            [['box', 'name', 'nominal', 'image', 'active'], 'safe'],
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
        $query = Elements::find();

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
         //   'idelements' => $this->idelements,
            'quantity' => $this->quantity,
            'idproduce' => $this->idproduce,
            'idcategory' => $this->idcategory,
          //  'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'box', $this->box])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nominal', $this->nominal])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
