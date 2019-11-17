<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "blog_thumbnail_images".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 *
 */
class ThumbnailBase extends \yii\db\ActiveRecord
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
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

}
