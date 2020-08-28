<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductReview;

/**
 * ProductReviewSearch represents the model behind the search form about `common\models\ProductReview`.
 */
class ProductReviewSearch extends ProductReview
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'raiting', 'active'], 'integer'],
            [['name', 'email', 'content'], 'safe'],
            [['created_at'], 'date', 'format'=>'dd-MM-yyyy', 'message'=>'{attribute} must be DD-MM-YYYY format.'],            
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
        $query = ProductReview::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'active' => $this->active,
            'raiting' => $this->raiting,
            'product_id' => $this->product->id,
        ]);

        $query->andFilterWhere(['like', 
            "(date_format(created_at, '%d-%m-%Y %h:%i:%s %p' ))",
            $this->created_at]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
