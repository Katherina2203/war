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
     public $searchstring;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelements', 'quantity', 'created_by' , 'updated_by', 'idcategory'], 'integer'],
            [['box', 'name', 'nominal', 'image', 'active', 'searchstring', 'idproduce'], 'safe'],
            ['name', 'trim'],
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
         $query = Elements::find()->With(['category', 'produce']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'idelements',
                    'box',
                    '{{%elements}}.name',
                    'nominal',
                    'quantity',
              //      'idcategory',
               //     'idproduce',
                    'idcategory'=>[
                        'asc' => ['{{%category}}.name' => SORT_ASC],
                        'desc' => ['{{%category}}.name'=> SORT_DESC],
                    ],
                    'idproduce'=>[
                        'asc' => ['{{%produce}}.manufacture' => SORT_ASC],
                        'desc' => ['{{%produce}}.manufacture'=> SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'active',
                ],
            ]
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

        
        $query = $query->andFilterWhere(['like', 'idelements', $this->idelements])
       //     ->andFilterWhere(['like', 'box', $this->box])
            ->andFilterWhere(['like', 'name', $this->name])
           // ->andFilterWhere(['like', 'nominal', $this->nominal])
          //  ->andFilterWhere(['like', 'nominal', $this->searchstring])
            ->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'name', $this->searchstring])
            ->andFilterWhere(['like', 'active', $this->active]);
        $nominalParam = preg_split('/\s+/', $this->nominal, -1, PREG_SPLIT_NO_EMPTY);
        foreach($nominalParam as $sParam) {
            $query->andFilterWhere(['like', 'nominal', $sParam]);
        }
        $query->orderBy(['quantity' => SORT_DESC]);

        return $dataProvider;
    }
}
