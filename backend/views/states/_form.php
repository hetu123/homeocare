<?php

use common\models\Countries;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\States */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="states-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country_id')->dropDownList(
        ArrayHelper::map(Countries::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Select Countries',
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'created_at')->textInput()

     $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
