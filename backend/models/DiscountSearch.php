<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Discount;
use common\models\DiscountToProduct;

/**
 * DiscountSearch represents the model behind the search form about `common\models\Discount`.
 */
class DiscountSearch extends Discount
{
    public $products;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'percent'], 'integer'],
            [['title', 'products'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format'=>'dd-MM-yyyy', 'message'=>'{attribute} must be DD-MM-YYYY format.'],            
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
        $query = Discount::find();

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

        if (!empty($this->products)) {

            $discount_ids = DiscountToProduct::find()
                ->select('discount_id')
                ->andFilterWhere(['product_id' => $this->products])
                ->asArray()->column();

            if ($discount_ids) {
                $query->andFilterWhere(['in', 'id', $discount_ids]);
            } else {
                $query->where('0=1');
            }
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'percent' => $this->percent,
        ]);

        $query->andFilterWhere(['like', 
            "(date_format(FROM_UNIXTIME(`date_from`), '%d-%m-%Y %h:%i:%s %p' ))",
            $this->date_from]);
        
        $query->andFilterWhere(['like', 
            "(date_format(FROM_UNIXTIME(`date_to`), '%d-%m-%Y %h:%i:%s %p' ))",
            $this->date_to]);
        
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
