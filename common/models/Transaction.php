<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property string $id
 * @property string $order_id
 * @property string $user_id
 * @property string $payment
 * @property double $price
 * @property integer $success
 * @property string $response_details
 * @property string $time
 */
class Transaction extends \yii\db\ActiveRecord
{
    public function appendResponse($r)
    {
        $this->response_details = $this->response_details . ' REQ-JSON:  ' . json_encode($r);
    }
    
    /**
     * before save
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->user_id = Yii::$app->user->id;
            $this->time = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'success'], 'integer'],
            [['price'], 'number'],
            [['response_details'], 'string'],
            [['time'], 'safe'],
            [['payment'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'payment' => 'Payment',
            'price' => 'Price',
            'success' => 'Success',
            'response_details' => 'Response Details',
            'time' => 'Time',
        ];
    }
}
