<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Themeunits;
use yii\db\Expression;
/**
 * ThemeunitsSearch represents the model behind the search form about `common\models\Themeunits`.
 */
class ThemeunitsSearch extends Themeunits
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idunit', 'idtheme', 'quantity_required', 'created_by' , 'edited_by'], 'integer'],
            [['nameunit'], 'safe'],
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
        $query = Themeunits::find()
                ->select(['{{%themeunits}}.*', 'boards_count' => new Expression('COUNT({{%boards}}.idboards)')])
                ->joinWith(['boards'], false)
                ->groupBy(['{{%themeunits}}.idunit']);

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
            'idunit' => $this->idunit,
            'idtheme' => $this->idtheme,
            'quantity_required' => $this->quantity_required,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'nameunit', $this->nameunit]);

        return $dataProvider;
    }
}
