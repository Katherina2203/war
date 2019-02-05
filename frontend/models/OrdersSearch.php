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
            [['idorder', 'idelement', 'idtheme', 'iduser', 'idstatus'], 'integer'],
            [['quantity'], 'safe'],
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

     //   $query -> joinWith('themes');
        // grid filtering conditions
        $query->andFilterWhere([
            'idorder' => $this->idorder,
            'idelement' => $this->idelement,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'idtheme' => $this->idtheme,
            'iduser' => $this->iduser,
            'idstatus' => $this->idstatus,
        ]);

        $query->andFilterWhere(['like', 'quantity', $this->quantity,
                    //     'like', 'idtheme', $this->idtheme
                ]);

        return $dataProvider;
    }
}
