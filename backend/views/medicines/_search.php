<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MedicinesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicines-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'language_id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'gujrati_name') ?>

    <?php // echo $form->field($model, 'hindi_name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'gujrati_description') ?>

    <?php // echo $form->field($model, 'hindi_description') ?>

    <?php // echo $form->field($model, 'dosages') ?>

    <?php // echo $form->field($model, 'solution_for') ?>

    <?php // echo $form->field($model, 'direction') ?>

    <?php // echo $form->field($model, 'indications') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'gujrati_tags') ?>

    <?php // echo $form->field($model, 'hindi_tags') ?>

    <?php // echo $form->field($model, 'total_stock') ?>

    <?php // echo $form->field($model, 'total_gst') ?>

    <?php // echo $form->field($model, 'use_stock') ?>

    <?php // echo $form->field($model, 'left_stock') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'manufacture_date') ?>

    <?php // echo $form->field($model, 'expiry_date') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'discount_in_amount') ?>

    <?php // echo $form->field($model, 'discount_in_percentage') ?>

    <?php // echo $form->field($model, 'MRP') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
