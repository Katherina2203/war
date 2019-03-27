<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Boards;

/**
 * BoardsSearch represents the model behind the search form about `common\models\Boards`.
 */
class BoardsSearch extends Boards
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idboards', 'idtheme', 'idthemeunit', 'quantity'], 'integer'],
            [['name', 'current', 'date_added', 'discontinued'], 'safe'],
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
        $query = Boards::find()->with(['themes', 'themeunits'])->orderBy('created_at DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_added'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idboards' => $this->idboards,
            'idtheme' => $this->idtheme,
            'idthemeunit' => $this->idthemeunit,
            'quantity' => $this->quantity,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'current', $this->current])
            ->andFilterWhere(['like', 'discontinued', $this->discontinued]);

        return $dataProvider;
    }
}
