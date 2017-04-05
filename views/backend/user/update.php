<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Users',
    ]) . ' ' . $user->getUserName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->getUserName(), 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');


?>
<div class="profile-container">
    <div class="profile-section">
        <div class="profile-left">
            <?= \dosamigos\fileupload\FileUpload::widget([
                'model' => $user,
                'attribute' => 'avatar',
                'url' => ['media/upload', 'id' => $user->id], // your url, this is just for demo purposes,
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'maxFileSize' => 2000000
                ],
                // Also, you can specify jQuery-File-Upload events
                // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                    'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                ],
            ]);?>


            <div class="profile-image">
                <img src="assets/img/profile-cover.jpg">
                <i class="fa fa-user hide"></i>
            </div>
            <div class="m-b-10">
                <a href="#" class="btn btn-warning btn-block btn-sm">Change Picture</a>
            </div>
            <div class="profile-highlight">
                <h4><i class="fa fa-cog"></i> Only My Contacts</h4>

                <div class="checkbox m-b-5 m-t-0">
                    <label><input type="checkbox"> Show my timezone</label>
                </div>
                <div class="checkbox m-b-0">
                    <label><input type="checkbox"> Show i have 14 contacts</label>
                </div>
            </div>
        </div>
        <div class="profile-right">
            <div class="profile-info">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-upd-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => '<td class="field">{label}</td><td>{input}</td><div class="col-sm-10">{error}</div>',
                        'labelOptions' => ['class' => ''],
                        'inputOptions' => ['class' => 'form-control input-inline input-xs'],
                    ],
                ]); ?>
                <div class="table-responsive">
                    <table class="table table-profile">
                        <thead>
                        <tr>
                            <th></th>
                            <th>
                                <h4><?= $user->username ?>
                                    <small>Lorraine Stokes</small>
                                </h4>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="highlight">
                            <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
                        </tr>
                        <tr class="divider">
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field">Mobile</td>
                            <td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)- 367-8924 <a href="#" class="m-l-5">Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="field">Home</td>
                            <td><a href="#">Add Number</a></td>
                        </tr>
                        <tr>
                            <td class="field">Office</td>
                            <td><a href="#">Add Number</a></td>
                        </tr>
                        <tr class="divider">
                            <td colspan="2"></td>
                        </tr>
                        <tr class="highlight">
                            <td class="field">About Me</td>
                            <td><a href="#">Add Description</a></td>
                        </tr>
                        <tr class="divider">
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field">Country/Region</td>
                            <td>
                                <select class="form-control input-inline input-xs" name="region">
                                    <option value="US" selected="">United State</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field">City</td>
                            <td>Los Angeles</td>
                        </tr>
                        <tr>
                            <td class="field">State</td>
                            <td><a href="#">Add State</a></td>
                        </tr>
                        <tr>
                            <td class="field">Website</td>
                            <td><a href="#">Add Webpage</a></td>
                        </tr>
                        <tr>
                            <td class="field">Gender</td>
                            <td>
                                <select class="form-control input-inline input-xs" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field">Birthdate</td>
                            <td>
                                <select class="form-control input-inline input-xs" name="day">
                                    <option value="04" selected="">04</option>
                                </select>
                                -
                                <select class="form-control input-inline input-xs" name="month">
                                    <option value="11" selected="">11</option>
                                </select>
                                -
                                <select class="form-control input-inline input-xs" name="year">
                                    <option value="1989" selected="">1989</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field">Language</td>
                            <td>
                                <select class="form-control input-inline input-xs" name="language">
                                    <option value="" selected="">English</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
