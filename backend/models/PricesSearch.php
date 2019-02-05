<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Prices;
use common\models\Currency;

/**
 * PricesSearch represents the model behind the search form about `common\models\Prices`.
 */
class PricesSearch extends Prices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpr', 'idel', 'idsup', 'idcurrency'], 'integer'],
            [['unitPrice', 'forUP', 'pdv', 'usd'], 'safe'],
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
        $query = Prices::find()->with(['supplier', 'elements']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          //  'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $dataProvider->sort = [ 'defaultOrder' => [ 'created_at' => SORT_DESC ] ];
        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idpr' => $this->idpr,
            'idcurrency' => $this->idcurrency,
        
        ]);

        $query->andFilterWhere(['like', 'idel', $this->idel])
            ->andFilterWhere(['like', 'idsup', $this->idsup])
          //  ->andFilterWhere(['like', 'idcurrency', $this->idcurrency])
            ->andFilterWhere(['like', 'unitPrice', $this->unitPrice])
            ->andFilterWhere(['like', 'forUP', $this->forUP])
            ->andFilterWhere(['like', 'pdv', $this->pdv])
            ->andFilterWhere(['like', 'usd', $this->usd]);

        return $dataProvider;
    }
}
