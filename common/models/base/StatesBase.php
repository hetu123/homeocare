<?php

namespace common\models\base;

use Yii;
use common\models\Cities;
use common\models\Countries;

/**
 * This is the model class for table "states".
*
    * @property integer $id
    * @property integer $country_id
    * @property string $name
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Cities[] $cities
            * @property Countries $country
    */
class StatesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'states';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['country_id'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'country_id' => 'Country ID',
    'name' => 'Name',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCities()
    {
    return $this->hasMany(Cities::className(), ['state_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCountry()
    {
    return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }
}