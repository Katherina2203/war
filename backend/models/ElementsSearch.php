<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use common\models\Elements;

/**
 * elementsSearch represents the model behind the search form about `common\models\Elements`.
 */
class ElementsSearch extends Elements
{
     public $searchstring;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelements', 'quantity', 'created_by' , 'updated_by', 'idcategory', 'idproduce'], 'integer'],
            [['box', 'name', 'nominal', 'image', 'active', 'searchstring'], 'trim'],
            [['active'], 'string', 'max' => 1],
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
    
    public function attributes()
    {
        return array_merge(parent::attributes(),[
            "manufacture",
            "category_name",
            "date_receive", //accounts.date_receive
            "expacted_quantity", // accounts.expacted_quantity
        ]);
    }
    
    public function search()
    {
        //the subquery to get account data of an elements
        $queryAccounts = (new Query())
            ->select([
                'idelem' => "min(`idelem`)",
                'date_receive' => "min(`date_receive`)", 
                'expacted_quantity' => "sum((quantity - received_quantity))"
            ])
            ->from('accounts')
            ->where(['in', 'status', ['2', '5']])
            ->groupBy('idelem')
        ;

        $queryElementsSearch = ElementsSearch::find()
            ->select([
                "e.idelements",
                'e.box',
                'e.name',
                'e.nominal',
                'e.quantity',
                "e.idproduce",
                "p.manufacture",
                "e.idcategory",
                "c.name as category_name",
                "e.active",
                "a.date_receive",
                "a.expacted_quantity",
            ])
            ->from(['e' => 'elements',])
            ->leftJoin(['p' => 'produce',], 'e.idproduce = p.idpr')
            ->leftJoin(['c' => 'category',], 'e.idcategory = c.idcategory')
            ->leftJoin(['a' => $queryAccounts,], 'a.idelem = e.idelements')
        ;

        if (!($this->load(Yii::$app->request->get()) && $this->validate())) {
            return $queryElementsSearch;
        }
        
        $aAttributes = Yii::$app->request->get('ElementsSearch');
        $bIsEmpty = true;
        foreach ($aAttributes as $sAttr) {
            if ($sAttr != '') {
                $bIsEmpty = false;
                break;
            }
        }
        if ($bIsEmpty) {
            return $queryElementsSearch;
        }
        
        $queryElementsSearch->andFilterWhere([
                'e.idelements' => $this->idelements,
                'e.quantity' => $this->quantity,
                'e.idproduce' => $this->idproduce,
                'e.idcategory' => $this->idcategory,
                'e.active' => $this->active,
            ])
            ->andFilterWhere(['like', 'e.box', $this->box])
            ->andFilterWhere(['like', 'e.name', $this->name])
            ->andFilterWhere(['like', 'e.name', $this->searchstring])
            ->andFilterWhere(['like', 'e.nominal', preg_split('/\s+/', $this->nominal, -1, PREG_SPLIT_NO_EMPTY)]);
        $queryElementsSearch->orderBy(['quantity' => SORT_DESC]);
        return $queryElementsSearch;
    }
}
