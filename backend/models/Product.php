<?php

namespace backend\models;

use Yii;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $title
 * @property double $price
 * @property string $status
 * @property string $order
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
    );
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['price'], 'number'],
            [['status', 'order'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'status' => 'Status',
            'order' => 'Order',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = 1;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Get Status Name
     * @return string
     */
    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }
}
