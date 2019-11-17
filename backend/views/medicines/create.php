<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Medicines */

$this->title = 'Create Medicines';
$this->params['breadcrumbs'][] = ['label' => 'Medicines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicines-create">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
    <?= $this->render('_form', [
        'model' => $model,
        'image'=>$image,
    ]) ?>

</div>
