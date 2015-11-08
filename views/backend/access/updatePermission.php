<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 25.08.2015
 * Time: 8:20
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование правила: ' . ' ' . $permit->description;
$this->params['breadcrumbs'][] = ['label' => 'Правила доступа', 'url' => ['permission']];
$this->params['breadcrumbs'][] = 'Редактирование правила';
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="links-form">

        <?php
        if (!empty($error)) {
            ?>
            <div class="error-summary">
                <?php
                echo implode('<br>', $error);
                ?>
            </div>
            <?php
        }
        ?>

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::label('Текстовое описание'); ?>
            <?= Html::textInput('description', $permit->description); ?>
        </div>

        <div class="form-group">
            <?= Html::label('Разрешенный доступ'); ?>
            <?= Html::textInput('name', $permit->name); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>