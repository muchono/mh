<?php

namespace backend\models;

use Yii;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../extensions/SEOstats' . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * This is the model class for table "product_href".
 *
 * @property string $id
 * @property string $product_id
 * @property string $title
 * @property string $url
 * @property string $status
 * @property string $traffic
 * @property string $google_pr
 * @property string $alexa_rank
 * @property double $da_rank
 * @property string $about
 */
class ProductHref extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_href';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'title', 'url'], 'required'],
            [['product_id', 'status', 'traffic', 'google_pr', 'alexa_rank'], 'integer'],
            [['da_rank'], 'number'],
            [['about'], 'string'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'title' => 'Title',
            'url' => 'Url',
            'status' => 'Status',
            'traffic' => 'Traffic',
            'google_pr' => 'Google Pr',
            'alexa_rank' => 'Alexa Rank',
            'da_rank' => 'Da Rank',
            'about' => 'About',
        ];
    }
	
	public function getStats()
	{
            $seostats = new \SEOstats\SEOstats;

            $seostats->setUrl('http://google.com');
            $this->alexa_rank = \SEOstats\Services\Alexa::getGlobalRank();
            $this->da_rank = round(\SEOstats\Services\Mozscape::getDomainAuthority(), 2);
            
            print_r($this);
	}
}
