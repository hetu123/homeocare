<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContactUs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-us-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_number')
    ->textInput(['type' => 'text', 'maxlength' => 13])
    ->label('Contact Number') 
    ?>
    <?= $form->field($model, 'support_and_inquiries')
    ->textInput(['type' => 'text', 'maxlength' => 13])
    ->label('Support &  Inquiries') 
    ?>
    <?= $form->field($model, 'complains')
    ->textInput(['type' => 'text', 'maxlength' => 13])
    ->label('Complains') 
    ?>
   <?= $form->field($model, 'tracking_and_delivery')
    ->textInput(['type' => 'text', 'maxlength' => 13])
    ->label('Tracking & Delivery') 
    ?>
    <?= $form->field($model, 'whats_app')
    ->textInput(['type' => 'text', 'maxlength' => 13])
    ->label('WhatsApp') 
    ?>

    <!-- $form->field($model, 'created_at')->textInput()  -->

    <!-- $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
