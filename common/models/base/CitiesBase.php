<?php

namespace common\models\base;

use Yii;
use common\models\Addresses;
use common\models\States;

/**
 * This is the model class for table "cities".
*
    * @property integer $id
    * @property integer $state_id
    * @property string $name
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Addresses[] $addresses
            * @property States $state
    */
class CitiesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'cities';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['state_id'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'state_id' => 'State ID',
    'name' => 'Name',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAddresses()
    {
    return $this->hasMany(Addresses::className(), ['city_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getState()
    {
    return $this->hasOne(States::className(), ['id' => 'state_id']);
    }
}