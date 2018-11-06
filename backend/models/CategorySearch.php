<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;
use yii\db\Expression;
/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{
   // public $grand_id;
    public $elements_count;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
              [['idcategory', 'parent', 'created_by' , 'edited_by', 'elements_count'], 'integer'],//'grand_id'
           // [['name', 'url'], 'safe'],
              [['name'], 'safe'],
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
        $query = Category::find()
                ->select(['{{%category}}.*', 'elements_count' => new Expression('COUNT({{%elements}}.idelements)')])
               // ->from(['c' => Category::tableName()])
                ->joinWith(['elements'], false)
              // ->with(['{{%category}}.parent'])
                ->groupBy('{{%category}}.idcategory, {{%category}}.parent')
                ->With(['parent']);
 /*
  * from(['c' => Category::tableName()])
  * ->joinWith([
  *    'parent' => function(ActiveQuery $query){
  *             $query->from('parent'=>Category::tableName());
  *     }
  * ])
  */
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'idcategory',
                    'name',
                    'parent',
                    'elements_count',
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{%category}}.idcategory' => $this->idcategory,
            '{{%category}}.parent' => $this->parent, //parent.parent
            '{{%category}}.name' => $this->name,
        ]);
        
        if(isset($this->elements_count)){
            $query->andHaving([
                'elements_count' => $this->elements_count,
            ]);
        }
        

        $query->andFilterWhere(['like', 'name', $this->name]);
          //  ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
