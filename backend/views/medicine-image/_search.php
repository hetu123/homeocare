<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MedicineImageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicine-image-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'medicine_id') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'image_dimension') ?>

    <?= $form->field($model, 'is_cover') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
