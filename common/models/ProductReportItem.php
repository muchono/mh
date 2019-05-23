<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_report_item".
 *
 * @property string $id
 * @property string $product_href_id
 * @property string $user_id
 * @property string $product_report_id
 */
class ProductReportItem extends \yii\db\ActiveRecord
{
    public $cases_count = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_report_item';
    }

    public static function findIndex() {
        return self::find()->groupBy(['product_href_id', 'product_report_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_href_id', 'user_id', 'product_report_id'], 'required'],
            [['id', 'product_href_id', 'user_id', 'product_report_id'], 'integer'],
        ];
    }
    
    /**
     * Get product href
     * @return ProductHref
     */
    public function getHref()
    {
        return $this->hasOne(\common\models\ProductHref::className(), ['id' => 'product_href_id']);
    } 
    
    /**
     * Get product report
     * @return ProductReport
     */
    public function getReport()
    {
        return $this->hasOne(\common\models\ProductReport::className(), ['id' => 'product_report_id']);
    }     
    
    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }     
    
    /**
     * Get cases
     * @return array
     */
    public function getCases()
    {
        $r =  self::find()
                ->select(['*, COUNT(*) AS cases_count'])
                ->where(['product_href_id' => $this->product_href_id, 'product_report_id' => $this->product_report_id])
                ->groupBy('user_id')->createCommand()->sql;
        
        print $r.'<br/>';
        
        
        return self::find()
                ->select(['*, COUNT(*) AS cases_count'])
                ->where(['product_href_id' => $this->product_href_id, 'product_report_id' => $this->product_report_id])
                ->groupBy('user_id');
    }
    
    /**
     * Get cases count
     * @return array
     */
    public function getCasesCount()
    {
        return $this->getCases()->count();
    }    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_href_id' => 'Product Href ID',
            'user_id' => 'User ID',
            'product_report_id' => 'Product Report ID',
        ];
    }
}
