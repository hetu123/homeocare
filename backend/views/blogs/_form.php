<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Thumbnail;


/* @var $this yii\web\View */
/* @var $model common\models\Blogs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blogs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

   /* $language=ArrayHelper::map(\common\models\Language::find()->where(['is_active' => '1'])->all(), 'id', 'name');
    echo $form->field($model, 'language_id')
        ->dropDownList(
            $language,

            ['id'=>'name','prompt'=>'Select language',['options' => [0 => ['Selected'=>'selected']]]]
        );*/
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>
    <!-- $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => ['/redactor/upload/image'],
            'fileUpload' => ['/redactor/upload/file'],
            'lang' => 'en',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ])
-->
    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'excerpt')->widget(\yii\redactor\widgets\Redactor::className()) ?>
    <?= $form->field($model, 'thumbnail_image')->fileInput() ?>

    <div>
        <?php if($model->thumbnail != '') { ?>
            <img height="150px" width="150px" id="<?php echo $model->id;?>" src="<?php echo $model->thumbnail;?>" alt=""><br /><br />
        <?php }?>
    </div>
    <div id="more_thumbnail_images">
        <span>Add More Image</span> <button id="add_more_iamge_button">+</button>
        <?php $more_exist_images = \common\models\BlogThumbnailImages::find()->where(['blog_id'=>$model->id])->all();?>
    </div>
    <div class="thumb-more-img">
        <?php foreach($more_exist_images as $image) {?>
            <div>
                <img height="150px" width="150px" src="<?php echo $image->image;?>" alt="">
                <a href="<?php echo Yii::$app->urlManager->createUrl(['blogs/delete-thumb-more', 'id' => $image->id]);?>" class="thumnail_more_image_close">Remove</a>

            </div>
        <?php } ?>
    </div>

    <?= $form->field($model, 'offer_url')->textInput(['maxlength' => true, 'placeholder' => 'Offer Url']); ?>

    <?= $form->field($model, 'is_featured')->checkBox(['label' => 'Is Featured'])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
