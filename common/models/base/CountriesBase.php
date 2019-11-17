<?php

namespace common\models\base;

use Yii;
use common\models\States;

/**
 * This is the model class for table "countries".
*
    * @property integer $id
    * @property string $name
    * @property string $created_at
    * @property string $updated_at
    *
            * @property States[] $states
    */
class CountriesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'countries';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getStates()
    {
    return $this->hasMany(States::className(), ['country_id' => 'id']);
    }
}