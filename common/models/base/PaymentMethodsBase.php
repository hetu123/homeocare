<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "payment_methods".
*
    * @property integer $id
    * @property string $name
    * @property string $code
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
*/
class PaymentMethodsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'payment_methods';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'code'], 'required'],
            [['is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'name' => 'Name',
    'code' => 'Code',
    'is_active' => 'Is Active',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}