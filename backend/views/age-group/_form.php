<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AgeGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="age-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'age_group')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'created_at')->textInput() 

     $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
