<?php

namespace common\models\base;

use Yii;
use common\models\Medicines;
use common\models\Type;

/**
 * This is the model class for table "medicine_type".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $type_id
    * @property string $created_at
    *
            * @property Medicines $medicine
            * @property Type $type
    */
class MedicineTypeBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_type';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'type_id'], 'required'],
            [['medicine_id', 'type_id'], 'integer'],
            [['created_at'], 'safe'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
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
    'type_id' => 'Type ID',
    'created_at' => 'Created At',
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
    public function getType()
    {
    return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
}