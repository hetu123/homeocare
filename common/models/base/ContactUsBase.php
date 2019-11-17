<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "contact_us".
*
    * @property integer $id
    * @property string $email
    * @property string $location
    * @property integer $contact_number
    * @property integer $support_and_inquiries
    * @property integer $complains
    * @property integer $tracking_and_delivery
    * @property integer $whats_app
    * @property string $created_at
    * @property string $updated_at
*/
class ContactUsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'contact_us';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['email', 'contact_number'], 'required'],
            [['contact_number', 'support_and_inquiries', 'complains', 'tracking_and_delivery', 'whats_app'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'location'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'email' => 'Email',
    'location' => 'Location',
    'contact_number' => 'Contact Number',
    'support_and_inquiries' => 'Support And Inquiries',
    'complains' => 'Complains',
    'tracking_and_delivery' => 'Tracking And Delivery',
    'whats_app' => 'Whats App',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}