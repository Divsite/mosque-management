<?php

use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use backend\models\Receiver;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use backend\models\Village;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'receivers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-index">

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

            <div class="row">
                <?= Html::a(Yii::t('app', 'create_receiver'), ['create'], ['class' => 'btn btn-success btn-margin']) ?>

                <?php if (Yii::$app->user->identity->can('print-receiver-barcode')) : ?>
                    <?= Html::a('<i class="fa fa-barcode"></i> ' . Yii::t('app', 'print_barcode'), ['print-receiver-barcode'], ['class' => 'btn btn-info btn-margin']) ?>
                <?php endif ?>

                <?php if (Yii::$app->user->identity->can('income-index')) : ?>
                    <?= Html::a('<i class="fa fa-dollar-sign"></i> ' . Yii::t('app', 'incomes'), ['income-index'], ['class' => 'btn btn-primary btn-margin']) ?>
                <?php endif ?>

                <?php if (Yii::$app->user->identity->can('expense-index')) : ?>
                    <?= Html::a('<i class="fa fa-money-bill-alt"></i> ' . Yii::t('app', 'expenses'), ['expense-index'], ['class' => 'btn btn-secondary btn-margin']) ?>
                <?php endif ?>
                
                <?php if (Yii::$app->user->identity->can('delete-all')) : ?>
                    <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('app', 'delete_all'), ['delete-all'],
                        [
                            'class' => 'btn btn-danger clear btn-margin',
                            'data' => [
                                'confirm' => Yii::t('app', 'are_you_sure_want_to_clear_all'),
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                <?php endif ?>

            </div>

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
                            'attribute' => 'receiver_type_id',
                            'filter' => ArrayHelper::map(ReceiverType::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->receiverType->name;
                            },
                        ],

                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'village_id',
                            'filter' => ArrayHelper::map(Village::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->village->name;
                            },
                        ],

                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'citizens_association_id',
                            'filter' => ArrayHelper::map(CitizensAssociation::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->citizens->name;
                            },
                        ],
                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'neighborhood_association_id',
                            'filter' => ArrayHelper::map(NeighborhoodAssociation::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->neighborhood->name;
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
                            'attribute' => 'status',
                            'value' => function ($model) {
                                if ($model->receiverType->code == "ZKT") {
                                    if ($model->status == Receiver::DONE_STATUS) {
                                        return Yii::t('app', 'distribution_has_been_over');
                                    } elseif ($model->status == Receiver::PENDING_STATUS) {
                                        return 
                                        '<div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                    role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                    aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>';
                                    } 
                                } elseif ($model->receiverType->code == "QRN") {
                                    if ($model->status == Receiver::NOT_CLAIM) {
                                        return Yii::t('app', 'not_claimed');
                                    } elseif ($model->status == Receiver::CLAIM) {
                                        return Yii::t('app', 'already_claimed');
                                    }
                                }
                            },
                            'filter'=> [
                                Receiver::DONE_STATUS => Yii::t('app', 'distribution_has_been_over'),
                                Receiver::PENDING_STATUS => Yii::t('app', 'distribution_in_progress'),
                                Receiver::NOT_CLAIM => Yii::t('app', 'not_claimed'),
                                Receiver::CLAIM => Yii::t('app', 'already_claimed'),
                            ],
                        ],   

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{view}',
                            'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                    ['view', 'id' => $model['id']], 
                                    ['title' => 'View']);
                            },
                            // 'update' => function($url, $model) {
                            //     return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                            //         ['update', 'id' => $model['id']], 
                            //         ['title' => 'Update']);
                            // },
                            // 'delete' => function($url, $model) {
                            //     return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                            //         ['delete', 'id' => $model['id']], 
                            //         ['title' => 'Delete',
                            //         'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //         'data-method'  => 'post']);
                            //     }
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
