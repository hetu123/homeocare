<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    $medicine=ArrayHelper::map(\common\models\Medicines::find()->where(['is_active' => '1'])->all(), 'id', 'name');
    echo $form->field($model, 'id')
        ->dropDownList(
            $medicine,

            ['id'=>'name','prompt'=>'Select Medicines',['options' => [0 => ['Selected'=>'selected']]]]
        );
    ?>
    <?= $form->field($model, 'total_stock')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
