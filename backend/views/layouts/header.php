<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">Welcome </span>
                            <span class="col-xs"><?php if(Yii::$app->user->isGuest){
                                    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                                }
                                else{?>
                                    <?=    Yii::$app->user->identity->username;
                                } ?></span>
                        </a>
                    </li>
                    <?=
                    $menuItems[] = '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Sign out',
                            ['class' => 'btn btn-link logout','style'=>"background-color:#dd4b39;border-color: #d73925;color:white"]
                        )
                        . Html::endForm()
                        . '</li>';  ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
