<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TimeSlot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="time-slot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'morning_hours_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'morning_hours_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'evening_hours_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'evening_hours_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_open')->textInput() ?>

    <!-- $form->field($model, 'created_at')->textInput() 

    $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
