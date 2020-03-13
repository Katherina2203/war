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

    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), [
            'users_surname', //users.surname
            'themes_name', //themes.name
            'themeunits_nameunit', //themeunits.nameunit
            'boards_idboards_name', //CONCAT(b.idboards, "  ", b.name) as boards_idboards_name
            'date_only', //DATE_FORMAT(outofstock.date, '%Y %m %d')
        ]);
    }
    
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $iElementsId = Yii::$app->request->get('idel') ? Yii::$app->request->get('idel') : Yii::$app->request->get('id');
        $queryOutofstockSearch = OutofstockSearch::find()
            ->select([
                "o.idofstock",
                'u.surname as users_surname',
                'o.quantity',
                "DATE_FORMAT(o.date, '%Y-%m-%d') as date_only",
                "o.date",
                't.name as themes_name',
                'tu.nameunit as themeunits_nameunit',
                'CONCAT(b.idboards, "  ", b.name) as boards_idboards_name',
                'o.ref_of_board',
            ])
            ->from([
                'u' => 'users',
                't' => 'themes',
                'o' => 'outofstock', 
            ])
            ->leftJoin(['tu' => 'themeunits'], 'o.idthemeunit = tu.idunit')
            ->leftJoin(['b' => 'boards',], 'o.idboart = b.idboards')
            ->where('o.iduser = u.id')
            ->andWhere('o.idtheme = t.idtheme')
            ->andWhere('o.idelement = :idelement', [':idelement' => $iElementsId])
            ;
        if (!$this->load(Yii::$app->request->get()) || !$this->validate()) {
            $queryOutofstockSearch->orderBy('o.date DESC');
            return $queryOutofstockSearch;
        }

        // grid filtering conditions
        $queryOutofstockSearch->andFilterWhere([
            'o.idofstock' => $this->idofstock,
            'o.iduser' => $this->iduser,
            'o.quantity' => $this->quantity,
            'o.idtheme' => $this->idtheme,
            'o.idthemeunit' => $this->idthemeunit,
            'o.idboart' => $this->idboart,
        ]);

        $queryOutofstockSearch->andFilterWhere(['like', 'ref_of_board', $this->ref_of_board]);

        $queryOutofstockSearch->orderBy('date_only DESC');
        return $queryOutofstockSearch;
    }
}
