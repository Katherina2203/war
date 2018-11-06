<?php

namespace frontend\models;

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
            [['idreceipt', 'id', 'quantity'], 'integer'],
            [['date_receive'], 'safe'],
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
        $query = Receipt::find();
        
        $query->joinWith(['elements']);
        // add conditions that should always apply here
            $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
            
        $dataProvider->sort = [ 'defaultOrder' => [ 'date_receive' => SORT_DESC ] ];
        $dataProvider->setSort([
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
        ]);
        
     
        
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idreceipt' => $this->idreceipt,
            'id' => $this->id,
            'quantity' => $this->quantity,
            'date_receive' => $this->date_receive,
        ]);
        
         $query->andFilterWhere(['like', 'quantity', $this->quantity])
               ->andFilterWhere(['like', 'elements.name', $this->elements])
            ->andFilterWhere(['like', 'elements.nominal', $this->elements]);

 

        return $dataProvider;
    }
}
