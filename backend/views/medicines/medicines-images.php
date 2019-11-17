<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Medicine Images: ';
$this->params['breadcrumbs'][] = ['label' => 'Medicine', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Back', 'url' => ['update?id=' . $_GET['id']]];
$this->params['breadcrumbs'][] = 'Medicine Images';
/** @var \common\models\DealImage $model */
?>
<div class="medicine-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <?= $form->field($model, 'medicineImages[]')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*', 'multiple' => true],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-success btn-upload']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
<br/>
<div class="medicine-form">
    <div class="col-lg-12 col-md-12">
        <?php
        foreach ($dataProvider->models as $item) {
            ?>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="thumbnail">
                    <img src="<?= $item->image ?>" class="medicine-images">
                    <div class="caption">
                        <div class="file-actions">
                            <div class="file-footer-buttons">
                                <?php if ($item->is_cover == 1) { ?>
                                    <?= Html::label('cover', ['class' => 'kv-file-zoom btn btn-xs btn-default']) ?>
                                <?php } else { ?>
                                    <?= Html::a('Make Cover', ['make-cover', 'id' => $item->id, 'medicine_id' => $item->medicine_id]) ?>
                                <?php } ?>

                                <?php if ($item->is_cover != 1) { ?>
                                    <div class="right">
                                        <?= Html::a('Delete', ['delete-image', 'id' => $item->id, 'medicine_id' => $item->medicine_id],
                                            [
                                                'class' => 'kv-file-zoom btn btn-xs btn-default','data' => [
                                                'confirm' => 'Are you sure you want to update this item?',
                                                'method' => 'post',],
                                            ]) ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
