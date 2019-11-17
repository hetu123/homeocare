<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AboutUs */

$this->title = 'Create About Us';
$this->params['breadcrumbs'][] = ['label' => 'About uses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-us-create">

    <!-- <h1> Html::encode($this->title) </h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
