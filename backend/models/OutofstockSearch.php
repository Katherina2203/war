<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Outofstock;

/**
 * OutofstockSearch represents the model behind the search form about `common\models\Outofstock`.
 */
class OutofstockSearch extends Outofstock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idofstock', 'idelement', 'iduser', 'quantity', 'idtheme', 'idthemeunit', 'idboart', 'idprice'], 'integer'],
            [['ref_of_board'], 'safe'], //here was date
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
        $query = Outofstock::find()->with(['users', 'themes', 'themeunits', 'boards']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //жадная загрузка
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idofstock' => $this->idofstock,
            'idelement' => $this->idelement,
            'iduser' => $this->iduser,
            'quantity' => $this->quantity,
            'date' => $this->date,
            'idtheme' => $this->idtheme,
            'idthemeunit' => $this->idthemeunit,
            'idboart' => $this->idboart,
            'idprice' => $this->idprice,
        ]);

        $query->andFilterWhere(['like', 'ref_of_board', $this->ref_of_board]);

        return $dataProvider;
    }
}
