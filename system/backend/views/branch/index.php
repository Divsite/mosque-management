<?php

use backend\models\BranchCategory;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BranchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'branch');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">
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

            <p>
                <?= Html::a(Yii::t('app', 'create_branch'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

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

                        'code',
                        'bch_type',
                        'bch_name',
                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'bch_category_id',
                            'filter' => ArrayHelper::map(BranchCategory::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->branchCategory->name;
                            },
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                    ['view', 'id' => $model['code']], 
                                    ['title' => 'View']);
                            },
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['update', 'id' => $model['code']], 
                                    ['title' => 'Update']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                    ['delete', 'id' => $model['code']], 
                                    ['title' => 'Delete',
                                     'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                     'data-method'  => 'post']);
                                }
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
