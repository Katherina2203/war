<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\Category;
use yii\db\Expression;

class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['idcategory', 'parent',], 'integer'],
            [['name'], 'string', 'max' => 46],
            [['name'], 'trim'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(),["parent_name",]);
    }
    
    public function search()
    {
//        SELECT `c`.*
//        FROM category `p` 
//        LEFT JOIN (
//            SELECT c1.*, c2.name as parent_name FROM category c1
//            LEFT JOIN category c2 on c1.parent = c2.idcategory
//        ) `c` ON (p.idcategory = c.parent OR c.idcategory = p.idcategory)
//        where p.parent = 0
//        order by p.name, c.parent, c.name
        $queryCategory = (new Query())
            ->select(['c1.*', 'parent_name' => "c2.name",])
            ->from(['c1' => 'category'])
            ->leftJoin(['c2' => 'category',], 'c1.parent = c2.idcategory')
        ;
        $queryCategorySearch = CategorySearch::find()
            ->select(['c.*',])
            ->from(['p' => 'category',])
            ->leftJoin(['c' => $queryCategory,], '(p.idcategory = c.parent OR c.idcategory = p.idcategory)')
            ->where('p.parent = 0')
            ->orderBy('p.name, c.parent, c.name')
        ;
//        Yii::info("\n******\n" . print_r($queryCategorySearch->createCommand()->rawSql, true) . "\n", 'ajax');

        if ($this->load(Yii::$app->request->get()) && $this->validate()) {
            $queryCategorySearch->andFilterWhere(['like', 'c.name', $this->name]);
        }
        return $dataProviderCategory = new ActiveDataProvider([
                'query' => $queryCategorySearch,
                'pagination' => [
                    'pageSize' => 40,
                ],
            ]);
    }
}
