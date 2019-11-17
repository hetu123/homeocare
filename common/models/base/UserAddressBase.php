<?php

namespace common\models\base;

use Yii;
use common\models\Addresses;
use common\models\User;

/**
 * This is the model class for table "user_address".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $address_id
    * @property string $created_at
    *
            * @property Addresses $address
            * @property User $user
    */
class UserAddressBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user_address';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'address_id'], 'required'],
            [['user_id', 'address_id'], 'integer'],
            [['created_at'], 'safe'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'id']],
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
    'created_at' => 'Created At',
];
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
    public function getUser()
    {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}