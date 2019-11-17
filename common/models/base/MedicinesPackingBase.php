<?php

namespace common\models\base;

use Yii;
use common\models\Medicines;
use common\models\Packing;

/**
 * This is the model class for table "medicine_packing".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $packing_id
    * @property string $created_at
    *
            * @property Medicines $medicine
            * @property Packing $packing
    */
class MedicinesPackingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_packing';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'packing_id'], 'required'],
            [['medicine_id', 'packing_id'], 'integer'],
            [['created_at'], 'safe'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
            [['packing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packing::className(), 'targetAttribute' => ['packing_id' => 'id']],
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
    'packing_id' => 'Packing',
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
    public function getPacking()
    {
    return $this->hasOne(Packing::className(), ['id' => 'packing_id']);
    }
}