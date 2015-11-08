<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['method' => 'POST']); ?>

    <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'status')->dropDownList(
            $statusArray,
            [
            'prompt' => Yii::t('userscube', 'STATUS_CHOOSE')
            ]
    ) ?>

    <?= Html::checkboxList('roles', null, $roles, ['separator' => '<br>']); ?>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('admincube', 'BUTTON_CREATE') : Yii::t('admincube', 'BUTTON_UPDATE'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
