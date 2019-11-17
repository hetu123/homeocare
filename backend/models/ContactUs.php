<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property int $id
 * @property int $email
 * @property string $location
 * @property int $contact_number
 * @property int $support_and_inquiries
 * @property int $complains
 * @property int $tracking_and_delivery
 * @property int $whats_app
 * @property string $created_at
 * @property string $updated_at
 */
class ContactUs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'contact_number'], 'required'],
            [['email', 'contact_number', 'support_and_inquiries', 'complains', 'tracking_and_delivery', 'whats_app'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
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
