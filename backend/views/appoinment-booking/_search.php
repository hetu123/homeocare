<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AppoinmentBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appoinment-booking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'age_group_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'time_slot_id') ?>

    <?= $form->field($model, 'symptoms') ?>

    <?php // echo $form->field($model, 'is_approve') ?>

    <?php // echo $form->field($model, 'is_cancel') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
