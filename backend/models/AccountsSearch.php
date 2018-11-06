<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Accounts;

/**
 * AccountsSearch represents the model behind the search form about `common\models\Accounts`.
 */
class AccountsSearch extends Accounts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idord', 'idelem', 'idprice', 'idinvoice', 'created_by' , 'edited_by'], 'integer'],
            [['quantity', 'account_date', 'account', 'delivery', 'date_receive', 'status'], 'safe'],
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
        $query = Accounts::find()
                ->with(['paymentinvoice', 'prices'])
                ->joinWith(['elements']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'attributes' => [
                    'idord',
                    'date_receive' => [
                         'default' => SORT_ASC,
                    ],
                    'idelem',
                    //=> [
                     //   'asc' => ['elements.name' => SORT_ASC],
                       // 'desc' => ['elements.name' => SORT_DESC],
                   // ],  
                    'idprice',
                    'idinvoice',
                    'status',
                    'quantity',
                    'amount',
                    'date_receive'
                ],
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
            'idord' => $this->idord,
            'idelem' => $this->idelem,
            'idprice' => $this->idprice,
            'account_date' => $this->account_date,
            'idinvoice' => $this->idinvoice,
            'status' => $this->status,
            'date_receive' => $this->date_receive,
        ]);

        $query->andFilterWhere(['like', 'accounts.quantity', $this->quantity])
                ->andFilterWhere(['like', 'account', $this->account])
                ->andFilterWhere(['like', 'idinvoice', $this->idinvoice])
                ->andFilterWhere(['like', 'idelem', $this->idelem])
              //  $query->joinWith(['vendor' => function ($q) {
                
              //  ->andFilterWhere(['like', 'elements.nominal', $this->idelem])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'delivery', $this->delivery]);
        
       
          
        return $dataProvider;
    }
}
