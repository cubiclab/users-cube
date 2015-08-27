<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 25.08.2015
 * Time: 8:17
 */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use cubiclab\admin\widgets\Panel;

use yii\grid\ActionColumn;

$this->title = 'PAGE_ROLE_MANAGMENT';
$this->params['breadcrumbs'][] = $this->title;


$boxButtons[] = '{create}';
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null;
//Html::a('Добавить роль', ['add-role'], ['class' => 'btn btn-success'])

Panel::begin(
    [
        'title' => $this->title,
        //'headStyle' => Panel::WARNING,
        //'fullColor' => true,
        'buttonsTemplate' => $boxButtons,
    ]
);

$dataProvider = new ArrayDataProvider([
    'allModels' => Yii::$app->authManager->getRoles(),
    'sort' => [
        'attributes' => ['name', 'description'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => DataColumn::className(),
            'attribute' => 'name',
            'label' => 'Роль'
        ],
        [
            'class' => DataColumn::className(),
            'attribute' => 'description',
            'label' => 'Описание'
        ],
        [
            'class' => DataColumn::className(),
            'label' => 'Разрешенные доступы',
            'format' => ['html'],
            'value' => function ($data) {
                return implode('<br>', array_keys(ArrayHelper::map(Yii::$app->authManager->getPermissionsByRole($data->name), 'description', 'description')));
            }
        ],
        [   'class' => 'yii\grid\ActionColumn',
            'contentOptions'=>['style'=>'max-width: 21px;'],
            'template' => '{update} {delete}',
            'buttons' =>
                [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fa fa-pencil"></span>', Url::toRoute(['update-role', 'name' => $model->name]), [
                            'title' => Yii::t('yii', 'Update'),
                            'class' => 'btn btn-xs btn-success',
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', Url::toRoute(['delete-role', 'name' => $model->name]), [
                            'title' => Yii::t('yii', 'Delete'),
                            'class' => 'btn btn-xs btn-success',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ]
        ],
    ]
]);

?>
