<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 25.08.2015
 * Time: 8:19
 */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Правила доступа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">
    <p>
        <?= Html::a('Добавить новое правило', ['add-permission'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $dataProvider = new ArrayDataProvider([
        'allModels' => Yii::$app->authManager->getPermissions(),
        'sort' => [
            'attributes' => ['name', 'description'],
        ],
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);
    ?>

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'name',
                'label'     => 'Правило'
            ],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'description',
                'label'     => 'Описание'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' =>
                    [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-permission', 'name' => $model->name]), [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]); },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete-permission','name' => $model->name]), [
                                'title' => Yii::t('yii', 'Delete'),
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
</div>