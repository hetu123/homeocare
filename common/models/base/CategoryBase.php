<?php

namespace common\models\base;

use Yii;
use common\models\Language;
use common\models\MedicineCategory;

/**
 * This is the model class for table "category".
*
    * @property integer $id
    * @property integer $language_id
    * @property integer $pid
    * @property string $name
    * @property string $description
    * @property string $image
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Language $language
            * @property MedicineCategory[] $medicineCategories
    */
class CategoryBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'category';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'pid', 'is_active'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
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
    'pid' => 'Pid',
    'name' => 'Name',
    'description' => 'Description',
    'image' => 'Image',
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
    public function getMedicineCategories()
    {
    return $this->hasMany(MedicineCategory::className(), ['category_id' => 'id']);
    }
}
