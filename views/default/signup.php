<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 13:58
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('userscube', 'SIGNUP_FORM_WELCOME_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($flash = Yii::$app->session->getFlash("success")): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <p><?= Yii::t('userscube', 'SIGNUP_FORM_WELCOME_MESSAGE') ?></p>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
            //'enableAjaxValidation' => true,
        ]); ?>

        <?= $form->field($user, 'email') ?>
        <?= $form->field($user, 'username') ?>
        <?= $form->field($user, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton(Yii::t('userscube', 'SIGNUP_FORM_SUBMIT_BTN_MESSAGE'), ['class' => 'btn btn-primary']) ?>

                <br/><br/>
                <?= Html::a(Yii::t('userscube', 'SIGNUP_FORM_LOGIN_LINK'), ["/users/login"]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    <?php endif; ?>

</div>