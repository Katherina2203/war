<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Specification;

/**
 * SpecificationSearch represents the model behind the search form about `app\models\Specification`.
 */
class SpecificationSearch extends Specification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'idelement', 'idboard', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'status'], 'safe'],
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
        $query = Specification::find();

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
            'id' => $this->id,
            'quantity' => $this->quantity,
            'idelement' => $this->idelement,
            'idboard' => $this->idboard,
            'status' => $this->status,
            'ref_of' => $this->ref_of,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
        
         $query
            ->andFilterWhere(['like', 'idelement', $this->idelement])

            ->andFilterWhere(['like', 'status', $this->status]);
           // ->andFilterWhere(['like', 'processing_count', $this->processing_count]);

        return $dataProvider;
    }
}
