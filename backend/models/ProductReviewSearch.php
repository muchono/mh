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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
