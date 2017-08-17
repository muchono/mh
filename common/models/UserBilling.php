<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_billing".
 *
 * @property string $id
 * @property string $user_id
 * @property string $full_name
 * @property string $email
 * @property string $phone_number
 * @property string $company_name
 * @property string $country
 * @property string $address
 * @property string $zip
 * @property string $city
 * @property string $payment
 * @property integer $agreed
 */
class UserBilling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country', 'email', 'phone_number', 'address', 'zip', 'city','payment'], 'required'],
            [['full_name'], 'required', 'when' => function ($model) {
                return empty($model->company_name);
            }],
            [['company_name'], 'required', 'when' => function ($model) {
                return empty($model->full_name);
            }],
            [['user_id', 'country', 'agreed'], 'integer'],
            [['full_name', 'email', 'phone_number', 'company_name', 'address', 'zip', 'city'], 'string', 'max' => 255],
            [['payment'], 'string', 'max' => 50],
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
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'company_name' => 'Company Name',
            'country' => 'Country',
            'address' => 'Address',
            'zip' => 'Zip',
            'city' => 'City',
            'payment' => 'Payment Method',
            'agreed' => 'Agreed',
        ];
    }
}
