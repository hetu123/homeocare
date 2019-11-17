<?php

namespace common\models\base;

use Yii;
use common\models\Blogs;
use common\models\Brand;
use common\models\Category;
use common\models\Composition;
use common\models\Conditions;
use common\models\Ingredients;
use common\models\Medicines;
use common\models\Packing;
use common\models\Type;

/**
 * This is the model class for table "language".
*
    * @property integer $id
    * @property string $name
    * @property string $code
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Blogs[] $blogs
            * @property Brand[] $brands
            * @property Category[] $categories
            * @property Composition[] $compositions
            * @property Conditions[] $conditions
            * @property Ingredients[] $ingredients
            * @property Medicines[] $medicines
            * @property Packing[] $packings
            * @property Type[] $types
    */
class LanguageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'language';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'code'], 'required'],
            [['is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 30],
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
    'code' => 'Code',
    'is_active' => 'Is Active',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBlogs()
    {
    return $this->hasMany(Blogs::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBrands()
    {
    return $this->hasMany(Brand::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategories()
    {
    return $this->hasMany(Category::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCompositions()
    {
    return $this->hasMany(Composition::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConditions()
    {
    return $this->hasMany(Conditions::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIngredients()
    {
    return $this->hasMany(Ingredients::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicines()
    {
    return $this->hasMany(Medicines::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPackings()
    {
    return $this->hasMany(Packing::className(), ['language_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTypes()
    {
    return $this->hasMany(Type::className(), ['language_id' => 'id']);
    }
}