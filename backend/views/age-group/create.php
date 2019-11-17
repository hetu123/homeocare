<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AgeGroup */

$this->title = 'Create Age Group';
$this->params['breadcrumbs'][] = ['label' => 'Age Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="age-group-create">

    <!-- <h1> Html::encode($this->title) </h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
