<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Purchaseorder;

/**
 * PurchaseorderSearch represents the model behind the search form about `common\models\Purchaseorder`.
 */
class PurchaseorderSearch extends Purchaseorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpo', 'idrequest', 'idelement'], 'integer'],
            [['quantity', 'date'], 'safe'],
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
        $query = Purchaseorder::find()->with(['elements']);

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
            'idpo' => $this->idpo,
            'idrequest' => $this->idrequest,
            'idelement' => $this->idelement,
            'quantity' => $this->quantity,
            'date' => $this->date,
         //   'delivery' => $this->delivery,
          //  'idinvoice' => $this->idinvoice,
        ]);

        $query->andFilterWhere(['like', 'idrequest', $this->idrequest])
            ->andFilterWhere(['like', 'idpo', $this->idpo])  
            ->andFilterWhere(['like', 'idelement', $this->idelement])
            ->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
