<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CategoryType;

/**
 * CategoryTypeSearch represents the model behind the search form about `common\models\CategoryType`.
 */
class CategoryTypeSearch extends CategoryType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcategory_type', 'idtype_of_products', 'idcategory'], 'integer'],
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
        $query = CategoryType::find();

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
            'idcategory_type' => $this->idcategory_type,
            'idtype_of_products' => $this->idtype_of_products,
            'idcategory' => $this->idcategory,
        ]);

        return $dataProvider;
    }
}
