<?php

namespace common\models\base;

use Yii;
use common\models\ApnsDevices;
use common\models\Cart;
use common\models\Message;
use common\models\Notification;
use common\models\OrderItem;
use common\models\Orders;
use common\models\Wishlist;

/**
 * This is the model class for table "user".
*
    * @property integer $id
    * @property string $fullname
    * @property string $username
    * @property string $gender
    * @property string $email
    * @property string $address
    * @property string $phonenumber
    * @property string $auth_key
    * @property string $password_hash
    * @property string $password_reset_token
    * @property string $profile_pic
    * @property string $google_id
    * @property string $facebook_id
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    * @property string $verification_token
    *
            * @property ApnsDevices[] $apnsDevices
            * @property Cart[] $carts
            * @property Message[] $messages
            * @property Message[] $messages0
            * @property Notification[] $notifications
            * @property Notification[] $notifications0
            * @property OrderItem[] $orderItems
            * @property Orders[] $orders
            * @property Wishlist[] $wishlists
    */
class UserBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['username', 'email', 'auth_key', 'password_hash'], 'required'],
            [['gender'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fullname', 'email', 'address', 'auth_key', 'password_hash', 'password_reset_token', 'profile_pic', 'google_id', 'facebook_id', 'verification_token'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 50],
            [['phonenumber'], 'string', 'max' => 25],
            [['email'], 'unique'],
            [['phonenumber'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'fullname' => 'Fullname',
    'username' => 'Username',
    'gender' => 'Gender',
    'email' => 'Email',
    'address' => 'Address',
    'phonenumber' => 'Phonenumber',
    'auth_key' => 'Auth Key',
    'password_hash' => 'Password Hash',
    'password_reset_token' => 'Password Reset Token',
    'profile_pic' => 'Profile Pic',
    'google_id' => 'Google ID',
    'facebook_id' => 'Facebook ID',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    'verification_token' => 'Verification Token',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getApnsDevices()
    {
    return $this->hasMany(ApnsDevices::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCarts()
    {
    return $this->hasMany(Cart::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMessages()
    {
    return $this->hasMany(Message::className(), ['from_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMessages0()
    {
    return $this->hasMany(Message::className(), ['to_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotifications()
    {
    return $this->hasMany(Notification::className(), ['from_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotifications0()
    {
    return $this->hasMany(Notification::className(), ['to_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrderItems()
    {
    return $this->hasMany(OrderItem::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrders()
    {
    return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWishlists()
    {
    return $this->hasMany(Wishlist::className(), ['user_id' => 'id']);
    }
}