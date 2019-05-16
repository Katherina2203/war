<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Themes;
use yii\db\Expression;

/**
 * ThemesSearch represents the model behind the search form about `common\models\Themes`.
 */
class ThemesSearch extends Themes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtheme'], 'integer'],
            [['projectnumber', 'designnumber', 'name', 'full_name', 'customer', 'description', 'subcontractor', 'quantity', 'date', 'status'], 'safe'],
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
        $query = Themes::find()
             
              //  ->select([['{{%themes}}.*'], ['units_count' => new Expression('COUNT({{%themeunits}}.idunit)')]])
                    //, 'boards_count' => new Expression('COUNT({{%boards}}.idboards)')
                ->joinWith(['themeunits', 'boards'], false)
                ->groupBy(['{{%themes}}.idtheme', '{{%themeunits}}.idunit']);
              //  ->with(['boards']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date'=>SORT_DESC]]
        ]);
        
    

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idtheme'=>$this->idtheme,
            'projectnumber'=>$this->projectnumber,
            'designnumber'=>$this->designnumber,
            'name'=>$this->name,
            'customer'=>$this->customer,
            'date'=>$this->date,
            'status'=>$this->status,
        ]);

        $query->andFilterWhere(['like', 'projectnumber', $this->projectnumber])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'customer', $this->customer])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'subcontractor', $this->subcontractor])
            ->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
