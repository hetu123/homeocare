<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineConditions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicine-conditions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'medicine_id')->textInput() ?>

    <?= $form->field($model, 'condition_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
