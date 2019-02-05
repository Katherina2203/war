<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Elements;

/**
 * elementsSearch represents the model behind the search form about `common\models\Elements`.
 */
class ElementsSearch extends Elements
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
     //   $query = Elements::find();
         $query = Elements::find()->with(['category', 'produce']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //жадная загрузка
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
         //   'idelements' => $this->idelements,
           // 'name' => $this->name,
           // 'nominal' => $this->nominal,
            'quantity' => $this->quantity,
            'idproduce' => $this->idproduce,
            'idcategory' => $this->idcategory,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'idelements', $this->idelements])
       //     ->andFilterWhere(['like', 'box', $this->box])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nominal', $this->nominal])
            ->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
