<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use common\models\Processingrequest;

/**
 * ProcessingrequestSearch represents the model behind the search form about `common\models\Processingrequest`.
 */
class ProcessingrequestSearch extends Processingrequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idprocessing', 'idresponsive', 'idpurchasegroup','idrequest'], 'integer'],
          //  [['created_at'], 'safe'],
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
        $query = Processingrequest::find()
                ->select(['{{%processingrequest}}.*', 'purchaseorder_count' => new Expression('COUNT({{%purchaseorder}}.idpo)')])
                ->joinWith(['purchaseorder'], false)
                ->with('users')
                ->groupBy(['{{%processingrequest}}.idprocessing']);
                //->orderBy('purchaseorder_count ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC],
                'attributes' => [
                    'idrequest',
                    'idresponsive',
                    'idprocessing',
                 /*   'purchaseorder_count' => [
                        'asc' => ['purchaseorder_count' => SORT_ASC],
                        'desc' => ['purchaseorder_count' => SORT_DESC],
                    ],*/
                    'created_at',
                ]
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
            'idprocessing' => $this->idprocessing,
            'idresponsive' => $this->idresponsive,
            'idpurchasegroup' => $this->idpurchasegroup,
            'idrequest' => $this->idrequest,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           // 'purchaseorder_count' => $this->purchaseorder_count,
        ]);
        
        $query->andFilterWhere(['like', 'idpurchasegroup', $this->idpurchasegroup])
            //  ->andFilterWhere(['like', 'processingrequest.purchaseorder_count', $this->purchaseorder_count])
              ->andFilterWhere(['like', 'processingrequest.idrequest', $this->idrequest])
              ->andFilterWhere(['like', 'created_at', $this->created_at]);
                
        return $dataProvider;
    }
}
