<?php

use common\models\Category;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
     <!--$form->field($model, 'pid')->textInput()-->
   <!-- --><?php
/*
    $category=ArrayHelper::map(\common\models\Category::findAll(['pid' => 0]), 'id', 'name');
    echo $form->field($model, 'pid')
        ->dropDownList(
            $category,

            ['id'=>'name','prompt'=>'Select one Parent Category',['options' => [0 => ['Selected'=>'selected']]]]
        );
    */?>
   <!-- --><?php
/*
    $language=ArrayHelper::map(\common\models\Language::find()->where(['is_active' => '1'])->all(), 'id', 'name');
    echo $form->field($model, 'language_id')
        ->dropDownList(
            $language,

            ['id'=>'name','prompt'=>'Select language',['options' => [0 => ['Selected'=>'selected']]]]
        );
    */?>

    <?= $form->field($model, 'pid')->dropDownList(
        ArrayHelper::map(Category::find()->where(['pid' => NULL])->all(), 'id', 'name'),
        [
            'prompt' => 'Select Parent Category',
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model,'image')->fileInput() ?>

    <!--$form->field($model, 'image')->textInput(['maxlength' => true])-->

   <!-- $form->field($model, 'is_active')->textInput()-->
    <?= $form->field($model, 'is_active')->dropDownList(['1' => 'Yes', '0' => 'No'], ['options'=>['1'=>['Selected'=>true]]])?>

     <!--$form->field($model, 'created_at')->textInput()

     $form->field($model, 'updated_at')->textInput() -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
