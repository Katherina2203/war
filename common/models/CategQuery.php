<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Categoryshortcut]].
 *
 * @see Categoryshortcut
 */
class CategQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Categoryshortcut[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Categoryshortcut|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
