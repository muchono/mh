<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductPage;

/**
 * ProductPageSearch represents the model behind the search form about `common\models\ProductPage`.
 */
class ProductPageSearch extends ProductPage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id'], 'integer'],
            [['title', 'description', 'guide_description', 'list_description', 'feature1', 'feature2', 'feature3', 'feature4', 'feature5', 'content'], 'safe'],
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
        $query = ProductPage::find();

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
            'id' => $this->id,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'guide_description', $this->guide_description])
            ->andFilterWhere(['like', 'list_description', $this->list_description])
            ->andFilterWhere(['like', 'feature1', $this->feature1])
            ->andFilterWhere(['like', 'feature2', $this->feature2])
            ->andFilterWhere(['like', 'feature3', $this->feature3])
            ->andFilterWhere(['like', 'feature4', $this->feature4])
            ->andFilterWhere(['like', 'feature5', $this->feature5])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
