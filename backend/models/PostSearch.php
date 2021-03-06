<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{

    public $categories;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'views', 'sent', 'active'], 'integer'],
            [['title', 'image', 'content', 'meta_description', 'meta_keywords', 'url_anckor','categories'], 'safe'],
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->categories)) {

            $ids = \common\models\PostToCategory::find()
                ->select('post_id')
                ->andFilterWhere(['category_id' => $this->categories])
                ->asArray()->column();

            if ($ids) {
                $query->andFilterWhere(['in', 'id', $ids]);
            } else {
                $query->where('0=1');
            }
        }   
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'views' => $this->views,
            'sent' => $this->sent,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 
            "(date_format(FROM_UNIXTIME(`created_at`), '%d-%m-%Y %h:%i:%s %p' ))",
            $this->created_at]);
        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'url_anckor', $this->url_anckor]);

        return $dataProvider;
    }
}
