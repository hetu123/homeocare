<?php

namespace common\models\base;

use Yii;
use common\models\Language;
use common\models\MedicineComposition;

/**
 * This is the model class for table "composition".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $name
    * @property string $weight_type
    * @property integer $weight
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Language $language
            * @property MedicineComposition[] $medicineCompositions
    */
class CompositionBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'composition';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'weight', 'is_active'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'weight_type'], 'string', 'max' => 255],
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
    'weight_type' => 'Weight Type',
    'weight' => 'Weight',
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
    public function getMedicineCompositions()
    {
    return $this->hasMany(MedicineComposition::className(), ['composition_id' => 'id']);
    }
}
