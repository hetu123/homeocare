<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineCategoryBase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicines-composition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'medicine_id')->textInput() ?>

    <?= $form->field($model, 'composition_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
