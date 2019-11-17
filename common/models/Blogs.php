<?php

namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;


class Blogs extends \common\models\base\BlogsBase
{
    public $thumbnail_image;
    public $more_thumbnail_images = array();

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['thumbnail_image'],'required','on'=>'update-thumbnail_image'],
                [['thumbnail_image'],'file','extensions'=>'png, jpg, gif']

            ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'thumbnail_image' => 'Image'
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

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function getImageUpload($thumbnail_image)
    {
        $path = Yii::$app->params['newsImagePath'] . date('Y') . '/' . date('m');
        $pathUrl = Yii::$app->params['newsImageUrl'] . date('Y') . '/' . date('m');
        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }
        $this->thumbnail = $pathUrl . '/' . $this->id . '.' . $thumbnail_image->extension;
        $fileUpload = $path . '/' . $this->id . '.' . $thumbnail_image->extension;
        $thumbnail_image->saveAs($fileUpload);
    }


}