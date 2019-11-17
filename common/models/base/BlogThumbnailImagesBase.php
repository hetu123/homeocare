<?php

namespace common\models\base;

use Yii;
use common\models\Blogs;

/**
 * This is the model class for table "blog_thumbnail_images".
*
    * @property integer $id
    * @property integer $blog_id
    * @property string $image
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Blogs $blog
    */
class BlogThumbnailImagesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'blog_thumbnail_images';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['blog_id'], 'required'],
            [['blog_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'string', 'max' => 255],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::className(), 'targetAttribute' => ['blog_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'blog_id' => 'Blog ID',
    'image' => 'Image',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBlog()
    {
    return $this->hasOne(Blogs::className(), ['id' => 'blog_id']);
    }
}