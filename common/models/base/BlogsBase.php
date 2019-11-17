<?php

namespace common\models\base;

use Yii;
use common\models\BlogThumbnailImages;
use common\models\Language;

/**
 * This is the model class for table "blogs".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $title
    * @property string $slug
    * @property string $description
    * @property string $excerpt
    * @property string $offer_url
    * @property string $thumbnail
    * @property string $blogs
    * @property integer $is_featured
    * @property string $created_at
    * @property string $updated_at
    *
            * @property BlogThumbnailImages[] $blogThumbnailImages
            * @property Language $language
    */
class BlogsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'blogs';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'is_featured'], 'integer'],
            [['slug', 'is_featured'], 'required'],
            [['description', 'excerpt'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'offer_url', 'thumbnail', 'blogs'], 'string', 'max' => 255],
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
    'title' => 'Title',
    'slug' => 'Slug',
    'description' => 'Description',
    'excerpt' => 'Excerpt',
    'offer_url' => 'Offer Url',
    'thumbnail' => 'Thumbnail',
    'blogs' => 'Blogs',
    'is_featured' => 'Is Featured',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBlogThumbnailImages()
    {
    return $this->hasMany(BlogThumbnailImages::className(), ['blog_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
