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
        return self::find()
                ->select('MAX('.self::tableName().'.id) as id, '.self::tableName().'.product_href_id, '.self::tableName().'.product_report_id,'
                . '(SELECT COUNT(*) FROM '.self::tableName().' st '
                . 'WHERE st.product_href_id = '.self::tableName().'.product_href_id '
                . 'AND st.product_report_id = '.self::tableName().'.product_report_id) as cases_count')
                ->groupBy(['product_href_id', 'product_report_id'])
                ->orderBy('cases_count DESC');
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
        return self::find()
                ->select(['MAX(id), product_href_id, product_report_id, user_id'])
                ->where(['product_href_id' => $this->product_href_id, 'product_report_id' => $this->product_report_id])
                ->groupBy('user_id');
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
