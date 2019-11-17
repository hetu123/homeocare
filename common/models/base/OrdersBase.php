<?php

namespace common\models\base;

use Yii;
use common\models\OrderItem;
use common\models\Addresses;
use common\models\PaymentMethods;
use common\models\User;

/**
 * This is the model class for table "orders".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $address_id
    * @property integer $payment_method_id
    * @property string $name
    * @property string $email
    * @property integer $is_order
    * @property integer $card_num
    * @property integer $card_cvc
    * @property integer $card_exp_month
    * @property integer $card_exp_year
    * @property double $paid_amount
    * @property integer $is_canceled
    * @property string $created_at
    * @property string $updated_at
    *
            * @property OrderItem[] $orderItems
            * @property Addresses $address
            * @property PaymentMethods $paymentMethod
            * @property User $user
    */
class OrdersBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'orders';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'address_id', 'payment_method_id', 'name', 'email', 'paid_amount'], 'required'],
            [['user_id', 'address_id', 'payment_method_id', 'is_order', 'card_num', 'card_cvc', 'card_exp_month', 'card_exp_year', 'is_canceled'], 'integer'],
            [['paid_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethods::className(), 'targetAttribute' => ['payment_method_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
    'address_id' => 'Address ID',
    'payment_method_id' => 'Payment Method ID',
    'name' => 'Name',
    'email' => 'Email',
    'is_order' => 'Is Order',
    'card_num' => 'Card Num',
    'card_cvc' => 'Card Cvc',
    'card_exp_month' => 'Card Exp Month',
    'card_exp_year' => 'Card Exp Year',
    'paid_amount' => 'Paid Amount',
    'is_canceled' => 'Is Canceled',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrderItems()
    {
    return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAddress()
    {
    return $this->hasOne(Addresses::className(), ['id' => 'address_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPaymentMethod()
    {
    return $this->hasOne(PaymentMethods::className(), ['id' => 'payment_method_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}