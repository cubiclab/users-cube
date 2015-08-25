<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 25.08.2015
 * Time: 14:03
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h3>Пользователь</h3>
<?= Html::a('Sign In', ['signin'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Sign Up', ['signup'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Sign Out', ['signout'], ['class' => 'btn btn-success']) ?> </br>

<h3>Управление ролями</h3>
<?= Html::a('Role', ['access/role'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Add Role', ['access/add-role'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Update Role', ['access/update-role'], ['class' => 'btn btn-success']) ?> </br>
</br>
<?= Html::a('Permission', ['access/permission'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Add Permission', ['access/add-permission'], ['class' => 'btn btn-success']) ?> </br>
<?= Html::a('Update Permission', ['access/update-permission'], ['class' => 'btn btn-success']) ?> </br>
