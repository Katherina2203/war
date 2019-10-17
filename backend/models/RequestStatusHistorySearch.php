<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RequestStatusHistory;

/**
 * RequestStatusHistorySearch represents the model behind the search form about `common\models\RequestStatusHistory`.
 */
class RequestStatusHistorySearch extends RequestStatusHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idreqstatus', 'idrequest', 'edited_by'], 'integer'],
            [['status', 'updated_at', 'note'], 'safe'],
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
    public function search($idrequest, $params)
    {
        $query = RequestStatusHistory::find()->where(['idrequest' => $idrequest]);

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
            'idreqstatus' => $this->idreqstatus,
            'idrequest' => $this->idrequest,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
