<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Packing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
/*
    $language=ArrayHelper::map(\common\models\Language::find()->where(['is_active' => '1'])->all(), 'id', 'name');
    echo $form->field($model, 'language_id')
        ->dropDownList(
            $language,

            ['id'=>'name','prompt'=>'Select language',['options' => [0 => ['Selected'=>'selected']]]]
        );
    */?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'weight_type')->textInput(['maxlength' => true]) ?>

     <!--$form->field($model, 'created_at')->textInput()

     $form->field($model, 'updated_at')->textInput()
-->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
