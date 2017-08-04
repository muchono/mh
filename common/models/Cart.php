<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property string $id
 * @property string $user_id
 * @property string $product_id
 * @property string $months
 * @property string $timestamp
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'months'], 'required'],
            [['user_id', 'product_id', 'months'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'months' => 'Months',
            'timestamp' => 'Timestamp',
        ];
    }
    
    /**
     * Count of cart items
     * @param integer $user_id User ID
     * @return integer
     */
    static public function getCountByUser($user_id)
    {
        return self::find()->where(['user_id' => $user_id])->count();
    }
}
