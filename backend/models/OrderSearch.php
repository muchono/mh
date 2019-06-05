<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use common\models\OrderToProduct;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    
    public $user_name;
    public $user_email;
    public $products;
    
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'payment_status', 'transaction_id'], 'integer'],
            [['total'], 'number'],
            [['payment_method', 'user_name', 'user_email','products'], 'safe'],
            [['created_at', 'updated_at'], 'date', 'format'=>'dd-MM-yyyy', 'message'=>'{attribute} must be DD-MM-YYYY format.'],
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
        $query = Order::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if (!empty($this->user_name) || !empty($this->user_email)) {
            $query->joinWith(['user']);
        }
        // add conditions that should always apply here
        
        
        if (!empty($this->products)) {

            $order_ids = OrderToProduct::find()
                ->select('order_id')
                ->andFilterWhere(['product_id' => $this->products])
                ->asArray()->column();

            if ($order_ids) {
                $query->andFilterWhere(['in', 'id', $order_ids]);
            } else {
                $query->where('0=1');
            }
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'total' => $this->total,
            'payment_status' => $this->payment_status,
            'transaction_id' => $this->transaction_id,
        ]);
        
        $query->andFilterWhere(['like', 
            "(date_format(FROM_UNIXTIME(`created_at`), '%d-%m-%Y %h:%i:%s %p' ))",
            $this->created_at]
        );

        $query->andFilterWhere(['like', 'user.name', $this->user_name]);
        $query->andFilterWhere(['like', 'user.email', $this->user_email]);
        $query->andFilterWhere(['like', 'payment_method', $this->payment_method]);

        return $dataProvider;
    }
}
