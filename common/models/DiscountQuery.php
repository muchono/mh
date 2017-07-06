<?php

namespace common\models;
use yii\db\ActiveQuery;
use common\models\Discount;

class DiscountQuery extends ActiveQuery
{
    /**
     * Add active query
     * @return ActiveQuery
     */
    public function active()
    {
        $time = time();
        return $this->andOnCondition(['status' => Discount::STATUS_ACTIVE])
                    ->andOnCondition(['<', 'date_from', $time])
                    ->andOnCondition(['>', 'date_to', $time]);
    }
    
    /**
     * Add lates query
     * @return ActiveQuery
     */
    public function latest()
    {
        return $this->orderBy('id DESC')->limit(1)->one();
    }    
}