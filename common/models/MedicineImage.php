<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
class MedicineImage extends \common\models\base\MedicineImageBase
{
    var $medicineImages;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),[
            [['medicineImages'], 'safe'],
            [['medicineImages'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ]);
    }

    public function getImageUpload($medicineImages = null, $id, $i)
    {
        if ($medicineImages != null) {
            $path = Yii::$app->params['medicineImagePath'] . date('Y') . '/' . date('m') . '/images';
            $pathUrl = Yii::$app->params['medicinImageUrl'] . date('Y') . '/' . date('m') . '/images';
            if (!file_exists($path)) {
                FileHelper::createDirectory($path);
            }
            $relativePath = Yii::$app->urlManager->getHostInfo(). '/' .$pathUrl . '/' . $id .'_'.time(). '_' . $i . '.' . $medicineImages->extension;
            $this->image = $relativePath;
            $fileUpload = $path . '/' . $id .'_'.time(). '_' . $i .'.' . $medicineImages->extension;
            $medicineImages->saveAs($fileUpload);
        }
    }
}