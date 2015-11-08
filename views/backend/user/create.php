<?php

use yii\helpers\Html;
use cubiclab\users\UsersCube;
use cubiclab\admin\widgets\Panel;

$this->title = Yii::t('userscube', 'PAGE_CREATE_USERS');

$this->params['breadcrumbs'][] = ['label' => Yii::t('userscube', 'PAGE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Panel::begin(
    [
        'title' => $this->title,
    ]
);

echo $this->render(
    '_form',
    [
        'user' => $user,
        'roles' => $roles,
        'statusArray' => $statusArray,
    ]
);

Panel::end();

?>