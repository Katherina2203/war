<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoices;

class InvoicesSearch extends Invoices{
    
    public function rules()
    {
        return [
            [['idord', 'idsup',  'idelements', 'idproduce', 'idcategory'], 'integer'],
            [['quantity', 'account_date', 'account', 'delivery', 'name', 'nominal', 'unitPrice', 'forUP', 'pdv', 'usd'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Invoices::find();

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
            'idord' => $this->idord,
            'idelements' => $this->idelements,
            'idcategory' => $this->idcategory,
            'account_date' => $this->account_date,
            'name' => $this->name,
            'account_date' => $this->account_date,
        ]);

        $query->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'delivery', $this->delivery]);

        return $dataProvider;
    }
}
