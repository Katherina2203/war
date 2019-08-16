<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use common\models\Requests;

/**
 * RequestsSearch represents the model behind the search form about `common\models\Requests`.
 */
class RequestsSearch extends Requests
{
    public $searchstring;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrequest', 'idproduce', 'idboard', 'iduser', 'quantity', 'idproject', 'idsupplier', 'estimated_executor', 'created_by', 'edited_by', 'estimated_category', 'estimated_idel', 'idtype'], 'integer'],
            [['name', 'description', 'required_date', 'img', 'created_at', 'updated_at', 'note', 'status'], 'safe'],
            [['name'], 'trim'],
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
        $query = Requests::find()
                ->select(['{{%requests}}.*', 'processing_count' => new Expression('COUNT({{%processingrequest}}.idprocessing)')])
               // ->where(['{{%themes}}.status' => 'active'])
                ->with(['themes', 'users', 'supplier'])
                ->joinWith(['processingrequest'], false)
                ->groupBy(['{{%requests}}.idrequest'])
                ->orderBy('processing_count ASC')
                ->orderBy('created_at DESC');

        // add conditions that should always apply here

       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC],
                 'attributes' => [
                    'idrequest',
                    'name',
                    'description',
                    'idproduce', 
                    'quantity',
                    'iduser',
                    'required_date',
                    'idproject',
                    'idboard',
                    'status',
                  //  'note',
                    'created_at' => [
                        'asc' => ['created_at' => SORT_ASC],
                        'desc' => ['created_at' => SORT_DESC],
                      //  'defaultOrder' => SORT_DESC,
                    ],
                ],
                ]
        ]);
        //жадная загрузка
      //  if (!($this->load($params) && $this->validate())) {
       //     return $dataProvider;
      //  }
        
         $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'requests.idrequest' => $this->idrequest,
          //  'type' => $this->type,
            'idproduce' => $this->idproduce,
            'iduser' => $this->iduser,
            'quantity' => $this->quantity,
            'idproject' => $this->idproject,
            'idboard' => $this->idboard,
            'idsupplier' => $this->idsupplier,
            'required_date' => $this->required_date,
            'created_at' => $this->created_at,
          //  'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'idtype' => $this->idtype,
            'estimated_executor' => $this->estimated_executor,
            'estimated_category' => $this->estimated_category,
            'estimated_idel' => $this->estimated_idel,
            'estimated_idel' => $this->estimated_idel,
        ]);

        $query
            //    ->andFilterWhere(['like', 'idrequest', $this->idrequest])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'iduser', $this->iduser])
            ->andFilterWhere(['like', 'idboard', $this->idboard])
            ->andFilterWhere(['like', 'status', $this->status]);
           // ->andFilterWhere(['like', 'processing_count', $this->processing_count]);

        return $dataProvider;
    }
}
