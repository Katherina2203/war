<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Adverts;

/**
 * AdvertsSearch represents the model behind the search form about `common\models\Adverts`.
 */
class AdvertsSearch extends Adverts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idadvert', 'iduser', 'ord'], 'integer'],
            [['content', 'created_at', 'updated_at'], 'safe'],
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
        $query = Adverts::find()->with(['users']);

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
            'idadvert' => $this->idadvert,
            'iduser' => $this->iduser,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'ord' => $this->ord,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'iduser', $this->iduser]);

        return $dataProvider;
    }
}
