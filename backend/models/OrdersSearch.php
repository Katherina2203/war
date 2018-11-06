<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idorder', 'req_quantity', 'idproduce', 'idsupplier', 'executor', 'qty', 'idtheme', 'iduser', 'idstatus'], 'integer'],
            [['name', 'req_date', 'aggr_date', 'suppl_date', 'date_payment', 'contract', 'date_onstock', 'date_recept', 'additional'], 'safe'],
            [['amount'], 'number'],
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
        $query = Orders::find();

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
            'idorder' => $this->idorder,
            'req_quantity' => $this->req_quantity,
            'idproduce' => $this->idproduce,
            'idsupplier' => $this->idsupplier,
            'req_date' => $this->req_date,
            'executor' => $this->executor,
            'aggr_date' => $this->aggr_date,
            'qty' => $this->qty,
            'amount' => $this->amount,
            'suppl_date' => $this->suppl_date,
            'date_payment' => $this->date_payment,
            'date_onstock' => $this->date_onstock,
            'date_recept' => $this->date_recept,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'idtheme' => $this->idtheme,
            'iduser' => $this->iduser,
            'idstatus' => $this->idstatus,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'contract', $this->contract])
            ->andFilterWhere(['like', 'additional', $this->additional]);

        return $dataProvider;
    }
}
