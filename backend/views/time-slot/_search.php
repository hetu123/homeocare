<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TimeSlotSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="time-slot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'day') ?>

    <?= $form->field($model, 'morning_hours_from') ?>

    <?= $form->field($model, 'morning_hours_to') ?>

    <?= $form->field($model, 'evening_hours_from') ?>

    <?php // echo $form->field($model, 'evening_hours_to') ?>

    <?php // echo $form->field($model, 'is_open') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
