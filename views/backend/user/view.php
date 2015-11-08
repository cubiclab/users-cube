<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 25.08.2015
 * Time: 8:44
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $user->getUserName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('userscube', 'PAGE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('userscube', 'ACTION_UPDATE'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('userscube', 'ACTION_DELETE'), ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('userscube', 'DELETE_CONFIRMATION'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status',
            'login_ip',
            'login_time:datetime',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

    <?= Html::checkboxList('roles', $user_permit, $roles, ['separator' => '<br>']); ?>

</div>
