<?php

namespace common\models;

use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[Boards]].
 *
 * @see Boards
 */
class BoardsQuery extends ActiveQuery
{
  /*  public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    
    public function active()
    {
         return $this->andWhere(['discontinued' => true]);
    }

    /**
     * @inheritdoc
     * @return Boards[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Boards|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
