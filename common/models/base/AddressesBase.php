<?php

namespace common\models\base;

use Yii;
use common\models\Cities;
use common\models\Orders;
use common\models\UserAddress;

/**
 * This is the model class for table "addresses".
*
    * @property integer $id
    * @property integer $city_id
    * @property string $address1
    * @property string $address2
    * @property string $pincode
    * @property integer $contact
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Cities $city
            * @property Orders[] $orders
            * @property UserAddress[] $userAddresses
    */
class AddressesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'addresses';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['city_id', 'contact'], 'integer'],
            [['address1', 'address2'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['pincode'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'city_id' => 'City ID',
    'address1' => 'Address1',
    'address2' => 'Address2',
    'pincode' => 'Pincode',
    'contact' => 'Contact',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCity()
    {
    return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrders()
    {
    return $this->hasMany(Orders::className(), ['address_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserAddresses()
    {
    return $this->hasMany(UserAddress::className(), ['address_id' => 'id']);
    }
}