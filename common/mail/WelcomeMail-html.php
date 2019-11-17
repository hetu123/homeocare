<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */


//$resetLink = 'http://dev.smesconnect.com/en/reset-password'.'?token='.$user->password_reset_token;
$link = Url::to('/',true);
?>

<h2 style="margin-top: 0;">Hello <?= Html::encode($user->fullname) ?>,</h2>

<p>Welcome to Homeocare, it’s great to have you with us!</p>


<p>If you require further details, please contact us:<br />
Telephone:<br />
Homeocare +9998 447 317</p>

<p>
Email:<br />
members@qicadvantageclub.com</p>
 
<p>We hope you enjoy buying medicine with us!</p>

<tr>
    <td width="15%"></td>
    <td align="center" width="70%" style="text-align: center;border-top: 1px solid #d7d7d7;padding: 20px 0;"><p style="font-family: 'Open Sans', sans-serif;margin: 0;color: #505050;font-size: 14px;">If you didn't Signup, please ignore this email.</p></td>
    <td width="15%"></td>
</tr>