<?php

use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use backend\models\Village;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EnvSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Envs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="env-index">

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="table-responsive table-nowrap">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center']
                    ],

                    [
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' =>'text-align:center;'],
                        'attribute' => 'user_id',
                        'value' => function ($model) {
                            return $model->user ? $model->user->name : null;
                        },
                    ],

                    [
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' =>'text-align:center;'],
                        'attribute' => 'village_id',
                        'filter' => ArrayHelper::map(Village::find()->all(), 'id', 'name'),
                        'value' => function ($model) {
                            return $model->village ? $model->village->name : null;
                        },
                    ],

                    [
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' =>'text-align:center;'],
                        'attribute' => 'citizen_association_id',
                        'filter' => ArrayHelper::map(CitizensAssociation::find()->all(), 'id', 'name'),
                        'value' => function ($model) {
                            return $model->citizen ? $model->citizen->name : null;
                        },
                    ],

                    [
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' =>'text-align:center;'],
                        'attribute' => 'neighborhood_association_id',
                        'filter' => ArrayHelper::map(NeighborhoodAssociation::find()->all(), 'id', 'name'),
                        'value' => function ($model) {
                            return $model->neighborhood ? $model->neighborhood->name : null;
                        },
                    ],
                    
                    [
                        'attribute' => 'registration_date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'registration_date',
                            'options' => ['class' => 'form-control'],
                            'pluginOptions' => [
                                'autoclose' => true,
                            ],
                        ]),
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Action',
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                    ['view', 'id' => $model['id']], 
                                    ['title' => 'View']);
                            },
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['update', 'id' => $model['id']], 
                                    ['title' => 'Update']);
                            },
                        ]
                    ],
                ],
            ]); ?>

        </div>

    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
    <!-- /.card-footer-->
</div>
</div>
