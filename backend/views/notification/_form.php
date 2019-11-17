<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_id')->textInput() ?>

    <?= $form->field($model, 'to_id')->textInput() ?>

    <?= $form->field($model, 'reference_id')->textInput() ?>

    <?= $form->field($model, 'fk_device_id')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Follow Request' => 'Follow Request', 'Request to join group' => 'Request to join group', 'Invite to join group' => 'Invite to join group', 'Accept group request' => 'Accept group request', 'Reject group Request' => 'Reject group Request', 'Group post' => 'Group post', 'Post comment' => 'Post comment', 'Rank changed' => 'Rank changed', 'Position changed' => 'Position changed', 'Reject Group Invitation' => 'Reject Group Invitation', 'Accept Group Invitation' => 'Accept Group Invitation', 'MESSAGE' => 'MESSAGE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'json_data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
