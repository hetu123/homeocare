<?php

namespace common\models;

use yii\helpers\ArrayHelper;

class BlogThumbnailImages extends \common\models\base\BlogThumbnailImagesBase
{
    public $more_thumbnail_images;

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['more_thumbnail_images'],'file', 'extensions'=>'png, jpg, gif']

            ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'more_thumbnail_images' => 'Thumbnail Image'
        ]);
    }

    /**
     * Finds Model by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }

}