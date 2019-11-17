<?php

namespace common\models\base;

use Yii;
use common\models\Language;
use common\models\MedicineIngredient;

/**
 * This is the model class for table "ingredients".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $name
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Language $language
            * @property MedicineIngredient[] $medicineIngredients
    */
class IngredientsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'ingredients';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'is_active'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'language_id' => 'Language',
    'name' => 'Name',
    'is_active' => 'Is Active',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineIngredients()
    {
    return $this->hasMany(MedicineIngredient::className(), ['ingredient_id' => 'id']);
    }
}
