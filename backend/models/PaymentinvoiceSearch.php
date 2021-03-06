<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Paymentinvoice;

/**
 * PaymentinvoiceSearch represents the model behind the search form about `common\models\Paymentinvoice`.
 */
class PaymentinvoiceSearch extends Paymentinvoice
{
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpaymenti', 'idsupplier', 'idpayer', 'created_by', 'edited_by'], 'integer'],
            [['invoice', 'date_invoice', 'date_payment', 'confirm', 'tracking_number', 'created_at', 'updated_at'], 'safe'],
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
        $query = Paymentinvoice::find()
                ->With(['payer', 'supplier']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
        //    'idpaymenti' => $this->idpaymenti,
            'idsupplier' => $this->idsupplier,
            'invoice' => $this->invoice,
            'date_invoice' => $this->date_invoice,
            'idpayer' => $this->idpayer,
            'date_payment' => $this->date_payment,
            'confirm' => $this->confirm,
            'tracking_number' => $this->tracking_number,
          //  'created_by' => $this->created_by,
          //  'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'idsupplier', $this->idsupplier])
            ->andFilterWhere(['like', 'idpayer', $this->idpayer])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'confirm', $this->confirm])
            ->andFilterWhere(['like', 'tracking_number', $this->tracking_number]);


        return $dataProvider;
    }
}
