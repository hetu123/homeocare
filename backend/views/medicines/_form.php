<?php

use common\models\Medicines;

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              -

/* @var $this yii\web\View */
/* @var $model common\models\Medicines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicines-form">
    <?php if ($model->id) { ?>
        <?= Html::a('Image Management', ['medicines-images', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <div class="right">
            <?php
            //        echo Html::a('<button class="btn btn-warning">Clone</button> ', Url::toRoute([ 'clone', 'id' => $model->id]), [ 'title' => Yii::t('app', 'Click to Clone This Deal'), 'data-method' => 'post']);
            //        echo Html::button('Clone', ['value' => Url::to(['clone','id'=>$model->id]), 'class' => 'btn btn-warning', 'id' => 'modalButton']);
            if ($model->is_active) {
//                    echo Html::a('<button class="btn btn-success">InActive</button> ', Url::toRoute(['change-is-active-update', 'id' => $model->id]), ['title' => Yii::t('app', 'Click to Deactive This Deal'), 'data-method' => 'post']);
                echo Html::button('Active', ['class' => 'btn btn-success dealStatus','onclick'=>"activeMedicine($model->id)", 'id' => $model->id, 'title' => Yii::t('app', 'Click to Inactive')]);
            } else {
                $url = Url::home(true);
                $preview_url = substr($url, 0, stripos($url, '/',8));
//                    echo Html::a('<button class="btn btn-success">Active</button> ', Url::toRoute(['change-is-active-update', 'id' => $model->id]), ['title' => Yii::t('app', 'Click to Deactive This Deal'), 'data-method' => 'post']);
                echo Html::button('InActive', ['class' => 'btn btn-danger dealStatus', 'onclick'=>"activeMedicine($model->id)",'id' => $model->id, 'title' => Yii::t('app', 'Click to Active')]);
            }
/*            echo Html::a('Preview', '/medicines/preview/' . $model->id, ['target' => '_blank', 'class' => 'btn btn-primary']);*/
            ?>
            <?php

            //Html::a('Preview', $preview_url.'/deal/preview/'.$model->id,['target'=>'_blank','class' => 'btn btn-primary']);

            ?>
        </div>
    <?php } ?>
    <br/><br/>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-sm-9" style="padding-left: 0;">
       <!-- --><?php
/*
        $language=ArrayHelper::map(\common\models\Language::find()->where(['is_active' => '1'])->all(), 'id', 'name');
        echo $form->field($model, 'language_id')
            ->dropDownList(
                $language,

                ['id'=>'name','prompt'=>'Select language',['options' => [0 => ['Selected'=>'selected']]]]
            );
        */?>
         <!--$form->field($model, 'code')->textInput(['maxlength' => true])-->
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'gujrati_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'hindi_name')->textInput(['maxlength' => true]) ?>

        <?php $category_list = ArrayHelper::map(\common\models\Category::find()->where(['is_active' => '1'])->all(), 'id', 'name'); ?>
        <?php
        if ($model->id) {
            $model->category_id = $selectedCategoryIds;
        }
        ?>

        <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
            'data' => $category_list,
            'options' => ['multiple' => true, 'placeholder' => '--Choose a Category--'],
            'language' => 'en',
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
        </div>
    <div class="col-sm-3">
        <?php if ($model->id) { ?>
            <div class="col-lg-12 col-md-12">
                <?php
                foreach ($dataProvider->models as $item) {
                    ?>
                    <?php if ($item->is_cover == 1) { ?>
                    <div class="thumbnail">

                        <img src="<?= $item->image ?>" class="medicine-image">
                        <div class="caption">
                            <div class="file-actions">
                                <div class="file-footer-buttons">
                                    <?php if ($item->is_cover === 1) { ?>
                                        <?= Html::label('cover', ['class' => 'kv-file-zoom btn btn-xs btn-default text-red ']) ?>
                                    <?php } ?>
                                    <div class="right">
                                        <?= Html::a('More >>', ['medicines-images', 'id' => $model->id]) ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="clearfix"></div>



    <?php $type_list = ArrayHelper::map(\common\models\Type::find()->where(['is_active' => '1'])->all(), 'id', 'type'); ?>
    <?php
    if ($model->id) {
        $model->type_id = $selectedTypeIds;
    }
    ?>
    <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
        'data' => $type_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Type--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php $brand_list = ArrayHelper::map(\common\models\Brand::find()->where(['is_active' => '1'])->all(), 'id', 'name'); ?>
    <?php
    if ($model->id) {
        $model->brand_id = $selectedBrandIds;
    }
    ?>
    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
        'data' => $brand_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Brand--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php
    $composition_list=ArrayHelper::map(
        \common\models\Composition::find()->where(['is_active' => '1'])->asArray()->all(),
        'id',
        function($model) {
            return $model['name'].' '.$model['weight'].' '.$model['weight_type'];
        }
    )
    ?>


    <?php
    if ($model->id) {
        $model->composition_id = $selectedCompositionIds;
    }
    ?>
    <?= $form->field($model, 'composition_id')->widget(Select2::classname(), [
        'data' => $composition_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Composition--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php $ingredient_list = ArrayHelper::map(\common\models\Ingredients::find()->where(['is_active' => '1'])->all(), 'id', 'name'); ?>
    <?php
    if ($model->id) {
        $model->ingredient_id = $selectedIngredientIds;
    }
    ?>
    <?= $form->field($model, 'ingredient_id')->widget(Select2::classname(), [
        'data' => $ingredient_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Ingredient--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>



    <?php $conditions_list = ArrayHelper::map(\common\models\Conditions::find()->where(['is_active' => '1'])->all(), 'id', 'condition'); ?>
    <?php
    if ($model->id) {
        $model->condition_id = $selectedConditionIds;
    }
    ?>
    <?= $form->field($model, 'condition_id')->widget(Select2::classname(), [
        'data' => $conditions_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Ingredient--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php
    $packing_list=ArrayHelper::map(
        \common\models\Packing::find()->asArray()->all(),
        'id',
        function($model) {
            return $model['weight'].' '.$model['weight_type'];
        }
    )
    ?>

    <?php
    if ($model->id) {
        $model->packing_id = $selectedPackingIds;
    }
    ?>
    <?= $form->field($model, 'packing_id')->widget(Select2::classname(), [
        'data' => $packing_list,
        'options' => ['multiple' => true, 'placeholder' => '--Choose a Packing--'],
        'language' => 'en',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'gujrati_description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'hindi_description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <!-- $form->field($model, 'description')->textarea(['rows' => 6])-->

    <?= $form->field($model, 'dosages')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <!--$form->field($model, 'dosages')->textarea(['rows' => 6])-->

    <?= $form->field($model, 'solution_for')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <!--$form->field($model, 'solution_for')->textarea(['rows' => 6])-->

    <?= $form->field($model, 'direction')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <!--$form->field($model, 'direction')->textarea(['rows' => 6])-->

    <?= $form->field($model, 'indications')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'tags')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'gujrati_tags')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'hindi_tags')->widget(\yii\redactor\widgets\Redactor::className()) ?>


    <!--$form->field($model, 'indications')->textarea(['rows' => 6]) -->

    <?= $form->field($model, 'total_stock')->textInput() ?>

    <?= $form->field($model, 'total_gst')->textInput() ?>

    <!--$form->field($model, 'use_stock')->textInput()

    $form->field($model, 'left_stock')->textInput() -->

    <!--$form->field($model, 'is_active')->textInput()-->
    <?= $form->field($model, 'is_active')->dropDownList(['1' => 'Yes', '0' => 'No'], ['options'=>['1'=>['Selected'=>true]]])?>


    <!--$form->field($model, 'expiry_date')->textInput()-->
    <div class="clearfix"></div>


    <?= '<label>Expiry Date</label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'expiry_date',
        'name' => 'expiry_date',
        //  'value' => date('d-M-Y', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select expiry date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            //  'todayHighlight' => true
        ]
    ]); ?>
</br>
    <?= '<label>Manufacture Date</label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'manufacture_date',
        'name' => '	manufacture_date',
        //  'value' => date('d-M-Y', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select 	manufacture date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            //  'todayHighlight' => true
        ]
    ]); ?>
    </br>
    <div>

        <label><input type="radio" name="colorRadio" value="price"> price</label>
        <span class="price box" hidden> <?= $form->field($model, 'price')->textInput() ?></span>

    </div>
    <div>
        <label><input type="radio" name="colorRadio" value="percentage">Discount In Percentage</label>
        <span class="percentage box" hidden><?= $form->field($model, 'discount_in_percentage')->textInput() ?></span>

    </div>
    <div>
        <label><input type="radio" name="colorRadio" value="amount"> Discount In Amount</label>
        <span class="amount box" hidden><?= $form->field($model, 'discount_in_amount')->textInput() ?></span>

    </div>


    <?= $form->field($model, 'MRP')->textInput() ?>



    <!--$form->field($model, 'created_at')->textInput()

    $form->field($model, 'updated_at')->textInput()
-->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script>
    function activeMedicine($id){
        var result = confirm("Are you sure ?");
        if(result){
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl. '/medicines/active' ?>',
                type: 'post',
                data: {id: $id },
                success: function (data) {
                    location. reload(true);
                }
            });
        }

    }

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".box").not(targetBox).hide();
            $(targetBox).show();
        });
    });
</script>