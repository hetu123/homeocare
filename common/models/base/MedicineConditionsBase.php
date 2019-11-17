<?php

namespace common\models\base;

use Yii;
use common\models\Conditions;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_conditions".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $condition_id
    * @property string $created_at
    *
            * @property Conditions $condition
            * @property Medicines $medicine
    */
class MedicineConditionsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_conditions';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'condition_id'], 'required'],
            [['medicine_id', 'condition_id'], 'integer'],
            [['created_at'], 'safe'],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conditions::className(), 'targetAttribute' => ['condition_id' => 'id']],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'medicine_id' => 'Medicine ID',
    'condition_id' => 'Condition ID',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCondition()
    {
    return $this->hasOne(Conditions::className(), ['id' => 'condition_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}