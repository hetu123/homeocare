<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogThumbnailImages */

$this->title = 'Update Blog Thumbnail Images: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Thumbnail Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-thumbnail-images-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
