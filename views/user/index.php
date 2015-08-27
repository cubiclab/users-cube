<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use cubiclab\admin\widgets\Panel;

$this->title = Yii::t('userscube', 'USERS');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<?php
$boxButtons = $actions = [];
$showActions = false;
//if (Yii::$app->user->can('ACPCreateUsers')) {
$boxButtons[] = '{create}';
//}
//if (Yii::$app->user->can('ACPUpdateUsers')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
//}
//if (Yii::$app->user->can('ACPDeleteUsers')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $showActions = $showActions || true;
//}
if ($showActions === true) {
    //$gridConfig['columns'][] = [
    //    'class' => ActionColumn::className(),
    //    'template' => implode(' ', $actions)
    //];
}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>

<?php Panel::begin(
    [
        'title' => $this->title,
        //'headStyle' => Panel::WARNING,
        //'fullColor' => true,


        //'bodyOptions' => [
        //    'class' => 'table-responsive'
        //],
        'buttonsTemplate' => $boxButtons,
        //'grid' => $gridId
    ]
); ?>

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

// End Panel
<?php Panel::end(); ?>