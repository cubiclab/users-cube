<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => CheckboxColumn::classname()
            ],
            'id',
            //'username',
            [
                'attribute' => 'username',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model['username'], ['update', 'id' => $model['id']], ['data-pjax' => 0]);
                }
            ],
            //'password',
            'email:email',
            //'auth_key',
            // 'api_key',
            //STATUS
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status === $model::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } elseif ($model->status === $model::STATUS_INACTIVE) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }
                    return '<span class="label ' . $class . '">' . $model->statusName . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $statusArray,
                    ['class' => 'form-control', 'prompt' => Yii::t('userscube', 'STATUS_CHOOSE')]
                )
            ],
            //ROLE
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    return $model->userRolesNames;
                }
            ],
            // 'login_ip',
            // 'login_time:datetime',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
