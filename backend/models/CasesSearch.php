<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cases;

/**
 * CasesSearch represents the model behind the search form about `common\models\Cases`.
 */
class CasesSearch extends Cases
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcase', 'created_by', 'updated_by'], 'integer'],
            [['value', 'LibraryRef', 'FootprintRef', 'LibraryPath', 'FootprintPath'], 'safe'],
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
        $query = Cases::find();

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
            'idcase' => $this->idcase,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'LibraryRef', $this->LibraryRef])
            ->andFilterWhere(['like', 'FootprintRef', $this->FootprintRef])
            ->andFilterWhere(['like', 'LibraryPath', $this->LibraryPath])
            ->andFilterWhere(['like', 'FootprintPath', $this->FootprintPath]);

        return $dataProvider;
    }
}
