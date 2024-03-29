<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpecificationTemplate;

/**
 * SpecificationTemplateSearch represents the model behind the search form about `app\models\SpecificationTemplate`.
 */
class SpecificationTemplateSearch extends SpecificationTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idspt', 'idelement', 'quantity'], 'integer'],
            [['ref_of_board'], 'safe'],
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
        $query = SpecificationTemplate::find();

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
            'idspt' => $this->idspt,
            'idelement' => $this->idelement,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'ref_of_board', $this->ref_of_board]);

        return $dataProvider;
    }
}
