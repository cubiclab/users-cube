<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 21.08.2015
 * Time: 10:47
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('userscube', 'SIGNIN_FORM_WELCOME_TITLE');
?>
<div class="login" data-pageload-addclass="animated fadeIn">
    <div class="login-header">
        <div class="brand">
            <span class="logo"></span> Cubic CRM
            <small><?= Yii::t('userscube', 'SIGNIN_FORM_WELCOME_MESSAGE') ?></small>
        </div>
        <div class="icon">
            <i class="fa fa-sign-in"></i>
        </div>
    </div>
    <div class="login-content">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'margin-bottom-0'],
            'fieldConfig' => [
                'template' => "<div class=\"form-group m-b-20\">{input}\n<div class=\"col-lg-7\">{error}</div></div>",
            ],
        ]);
        //username field
        echo $form->field($model, 'username', [
            'inputOptions' => ['class' => 'form-control input-lg', 'placeholder' => Yii::t('userscube', 'ATTR_USERNAME')]]);

        //password field
        echo $form->field($model, 'password', [
            'inputOptions' => ['class' => 'form-control input-lg', 'placeholder' => Yii::t('userscube', 'ATTR_PASSWORD')]
        ])->passwordInput();

        //remember me
        echo $form->field($model, 'rememberMe', [
            'template' => "<div class=\"checkbox m-b-20\"><label>{input} {label}</label></div><div class=\"col-lg-7\">{error}</div>",
        ])->checkbox();

        ?>
        <div class="login-buttons">
            <?= Html::submitButton(Yii::t('userscube', 'SIGNIN_FORM_SUBMIT_BTN_MESSAGE'), ['class' => 'btn btn-success btn-block btn-lg']) ?>
        </div>
        <div class="m-t-20"><br>
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_REGISTER'), ["/user/register"]) ?> /
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_FORGOT_PWD') . "?", ["/user/forgot"]) ?> /
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_RESEND_CONF_EMAIL'), ["/user/resend"]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>