<?php

use backend\models\CharityType;
use backend\models\CharityTypeSource;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CharityTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'charity_type');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="charity-type-index">

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
                <?= Html::a(Yii::t('app', 'create_charity_type'), ['create'], ['class' => 'btn btn-success']) ?>
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

                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'charity_type_source_id',
                            'filter' => CharityTypeSource::getListCharityTypeSource(),
                            'value' => function ($model) {
                                return $model->charitySource->name;
                            },
                        ],

                        // 'min:currency:Min',
                        // 'max:currency:Max',
                        [
                            'attribute' => 'min',
                            'value' => function ($model) {
                                if ($model->min) {
                                    return Yii::$app->formatter->asCurrency($model->min, 'IDR');
                                } else {
                                    return '-';
                                }
                            },
                        ],
                        
                        [
                            'attribute' => 'max',
                            'value' => function ($model) {
                                if ($model->max) {
                                    return Yii::$app->formatter->asCurrency($model->max, 'IDR');
                                } else {
                                    return '-';
                                }
                            },
                        ],

                        [
                            'attribute' => 'total_rice',
                            'value' => function ($model) {
                                if ($model->total_rice) {
                                    return $model->total_rice . ' LITER';
                                } else {
                                    return '-';
                                }
                            },
                        ],

                        [
                            'attribute' => 'registration_year',
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'registration_year',
                                'options' => ['class' => 'form-control', 'id' => 'registration-year-filter'],
                                'pluginOptions' => [
                                    'format' => 'yyyy',
                                    'autoclose' => true,
                                    'startView' => 'years',
                                    'minViewMode' => 'years',
                                ],
                            ]),
                        ],

                        [
                            'format' => 'raw',
                            'attribute' => 'is_active',
                            'value' => function ($model) {
                                if ($model->is_active == CharityType::ACTIVE) {
                                    return '<i class="fa fa-check"></i>';
                                } else {
                                    return '<i class="fa fa-times"></i>';
                                }
                            },
                            'filter'=> [
                                0 => Yii::t('app', 'nonactive'),
                                1 => Yii::t('app', 'active'),
                            ],
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{update} {delete}',
                            'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['update', 'id' => $model['id']], 
                                    ['title' => 'Update']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                    ['delete', 'id' => $model['id']], 
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

<?php
$js = <<< JS
    $('#registration-year-filter').on('click', function(){
        $(this).datepicker({
            changeYear: true,
            yearRange: '1900:' + new Date().getFullYear(),
            dateFormat: 'yy',
            showButtonPanel: true,
        }).focus();
    });
JS;

$this->registerJs($js);

?>