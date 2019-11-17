<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppoinmentBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appoinment-booking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'age_group_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'time_slot_id')->textInput() ?>

    <?= $form->field($model, 'symptoms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_approve')->textInput() ?>

    <?= $form->field($model, 'is_cancel')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'created_at')->textInput() 

    $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
