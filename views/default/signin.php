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
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('userscube', 'SIGNIN_FORM_WELCOME_MESSAGE') ?></p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe', [
        'template' => "{label}<div class=\"col-lg-offset-2 col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Yii::t('userscube', 'SIGNIN_FORM_SUBMIT_BTN_MESSAGE'), ['class' => 'btn btn-primary']) ?>

            <br/><br/>
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_REGISTER'), ["/user/register"]) ?> /
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_FORGOT_PWD') . "?", ["/user/forgot"]) ?> /
            <?= Html::a(Yii::t('userscube', 'SIGNIN_FORM_RESEND_CONF_EMAIL'), ["/user/resend"]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>