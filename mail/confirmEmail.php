<?php
/**
 * Created by PhpStorm.
 * User: Pt1c
 * Date: 15.11.2015
 * Time: 19:11
 */

use yii\helpers\Url;
use cubiclab\users\UsersCube;
?>

<h3><?= $subject ?></h3>

<p><?= UsersCube::t('userscube', 'MAIL_CONFIRMATION_BODY') ?></p>

<p><?= Url::toRoute(["/user/confirm", "token" => $userToken->token], true); ?></p>