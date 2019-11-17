<?php

namespace common\models;

use common\models\base\NewsBase;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;


class Thumbnail extends \common\models\base\ThumbnailBase
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
