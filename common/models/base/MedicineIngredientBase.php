<?php

namespace common\models\base;

use Yii;
use common\models\Ingredients;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_ingredient".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $ingredient_id
    * @property string $created_at
    *
            * @property Ingredients $ingredient
            * @property Medicines $medicine
    */
class MedicineIngredientBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_ingredient';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'ingredient_id'], 'required'],
            [['medicine_id', 'ingredient_id'], 'integer'],
            [['created_at'], 'safe'],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredients::className(), 'targetAttribute' => ['ingredient_id' => 'id']],
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
    'ingredient_id' => 'Ingredient',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIngredient()
    {
    return $this->hasOne(Ingredients::className(), ['id' => 'ingredient_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}
