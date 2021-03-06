<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Requests;

/**
 * RequestsSearch represents the model behind the search form about `common\models\Requests`.
 */
class RequestsSearch extends Requests
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrequest', 'idproduce', 'iduser', 'quantity', 'idproject', 'idsupplier'], 'integer'],
            [['name', 'description', 'required_date', 'img', 'created_at', 'updated_at', 'note', 'status'], 'safe'],
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
        $query = Requests::find();

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
            'idrequest' => $this->idrequest,
         //   'type' => $this->type,
            'idproduce' => $this->idproduce,
            'iduser' => $this->iduser,
            'quantity' => $this->quantity,
            'idproject' => $this->idproject,
            'idsupplier' => $this->idsupplier,
            'required_date' => $this->required_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
