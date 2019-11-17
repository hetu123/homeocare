<?php
/**
 * Created by PhpStorm.
 * User: Hetal
 * Date: 09-05-2018
 * Time: 10:35 AM
 */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!------ Include the above in your HEAD tag ---------->

    <style>
        .form-gap {
            padding-top: 70px;
        }
        a:hover{
            outline: none;
            text-decoration: none;
            color: #72afd2;
        }
        a:hover{
            outline: none;
            text-decoration: none;
        }
    </style>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="background: #d2d6de;">
<div class="form-gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div style="font-size: 35px;text-align: center;margin-bottom: 25px; font-weight: 300;">
                <a href="#" style="color: #444;"><b>HOMEO</b>CARE</a>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">

                        <?php $this->beginBody() ?>
                        <div>
                            <?= Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]) ?>
                            <?= Alert::widget() ?>
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
<?php $this->endPage() ?>
