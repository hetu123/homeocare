<?php

use common\models\States;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Cities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'state_id')->dropDownList(
        ArrayHelper::map(States::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Select States',
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'created_at')->textInput()

     $form->field($model, 'updated_at')->textInput()  -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
