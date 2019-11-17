<?php

namespace common\models\base;

use Yii;
use common\models\Medicines;
use common\models\User;

/**
 * This is the model class for table "cart".
*
    * @property integer $id
    * @property integer $user_id
    * @property string $anonymous_identifier
    * @property integer $medicine_id
    * @property double $store_price
    * @property integer $discount
    * @property integer $quantity
    * @property double $total_price
    * @property double $paid_price
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Medicines $medicine
            * @property User $user
    */
class CartBase extends \yii\db\ActiveRecord
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
            [['user_id', 'medicine_id', 'discount', 'quantity'], 'integer'],
            [['store_price', 'total_price', 'paid_price'], 'required'],
            [['store_price', 'total_price', 'paid_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['anonymous_identifier'], 'string', 'max' => 255],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
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
    'anonymous_identifier' => 'Anonymous Identifier',
    'medicine_id' => 'Medicine ID',
    'store_price' => 'Store Price',
    'discount' => 'Discount',
    'quantity' => 'Quantity',
    'total_price' => 'Total Price',
    'paid_price' => 'Paid Price',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}