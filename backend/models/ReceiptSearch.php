<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Receipt;

/**
 * ReceiptSearch represents the model behind the search form about `common\models\Receipt`.
 */
class ReceiptSearch extends Receipt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idreceipt', 'quantity', 'idinvoice'], 'integer'],
            [['date_receive', 'id'], 'safe'],
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
        $query = Receipt::find()
             //   ->select(['{{%receipt}}.*', 'request' => '{{%requests}}.idrequest'])
                ->with(['requests'])
                ->joinWith('elements', true, 'LEFT JOIN')
             //   ->orderBy('request DESC')
                ->with(['accounts']);

     //   $query->joinWith('elements', true, 'LEFT JOIN'); 

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_receive'=>SORT_DESC]]
        ]);

      /*   $dataProvider->setSort([
            'attributes' => [
                'date_receive' => [
                'asc' => [
                    'date_receive' => SORT_ASC, 
                ],
                'desc' => [
                    'date_receive' => SORT_DESC, 
                ],
                'label' => 'Дата',
                'default' => SORT_DESC,
            ],
       * 'name' => [
                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
       * 
             'elements' => [
                 'asc' => [
                     'elements.name' => SORT_ASC
                 ], 
                 'desc' => [
                     'elements.name' => SORT_DESC
                 ],
             ],
                'quantity',
                
            ]
        ]);*/
         
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idreceipt' => $this->idreceipt,
         //   'id' => $this->id,
            'quantity' => $this->quantity,
         //   'name' => $this->elements,
            'idinvoice' => $this->idinvoice,
            'date_receive' => $this->date_receive,
            
            'request' => $this->request,
        ]);
        
         $query->andFilterWhere(['like', 'id', $this->id])
       //     ->andFilterWhere(['like', 'box', $this->box])
           // ->andFilterWhere(['like', 'elements.name', $this->name])
           ->andFilterWhere(['like', 'elements.nominal', $this->id]);

        return $dataProvider;
    }
}
