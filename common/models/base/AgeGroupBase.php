<?php

namespace common\models\base;

use Yii;
use common\models\AppoinmentBooking;

/**
 * This is the model class for table "age_group".
*
    * @property integer $id
    * @property string $age_group
    * @property string $created_at
    * @property string $updated_at
    *
            * @property AppoinmentBooking[] $appoinmentBookings
    */
class AgeGroupBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'age_group';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['age_group'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'age_group' => 'Age Group',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAppoinmentBookings()
    {
    return $this->hasMany(AppoinmentBooking::className(), ['age_group_id' => 'id']);
    }
}