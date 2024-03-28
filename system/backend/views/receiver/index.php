<?php

use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use backend\models\Receiver;
use backend\models\ReceiverClass;
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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?= Yii::t('app', 'all_distribution_data')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?= Yii::t('app', 'charity')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><?= Yii::t('app', 'sacrifice') ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <?= Html::a(Yii::t('app', 'create_receiver'), ['create'], ['class' => 'btn btn-success btn-margin']) ?>
                        <?php if (Yii::$app->user->identity->can('income-index')) : ?>
                            <?= Html::a('<i class="fa fa-dollar-sign"></i> ' . Yii::t('app', 'incomes'), ['income-index'], ['class' => 'btn btn-primary btn-margin']) ?>
                        <?php endif ?>

                        <?php if (Yii::$app->user->identity->can('expense-index')) : ?>
                            <?= Html::a('<i class="fa fa-money-bill-alt"></i> ' . Yii::t('app', 'expenses'), ['expense-index'], ['class' => 'btn btn-secondary btn-margin']) ?>
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
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' =>'text-align:center;'],
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
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' =>'text-align:center;'],
                                    'value' => function ($model) {
                                        if ($model->receiverType->code == "ZKT") {
                                            if ($model->status == Receiver::DONE_STATUS) {
                                                return '<button class="btn btn-success"><i class="fa fa-check"></i> ' . Yii::t('app', 'distribution_has_been_over') . '</button>';
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
                                    ]
                                ],
                            ],
                        ]); ?>

                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderZakat,
                        'filterModel' => $searchModelZakat,
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
                                'attribute' => 'receiver_class_id',
                                'filter' => ReceiverClass::getListReceiverClass(),
                                'value' => function ($model) {
                                    return $model->receiverClass ? $model->receiverClass->receiverClassSource->name : null;
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
                                    'options' => ['class' => 'form-control', 'id' => 'registration-year-filter-charity'],
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
                                            return '<button class="btn btn-success"><i class="fa fa-check"></i> ' . Yii::t('app', 'distribution_has_been_over') . '</button>';
                                        } elseif ($model->status == Receiver::PENDING_STATUS) {
                                            return 
                                            '<div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                        role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: 100%">
                                                </div>
                                            </div>';
                                        } 
                                    }
                                },
                                'filter'=> [
                                    Receiver::DONE_STATUS => Yii::t('app', 'distribution_has_been_over'),
                                    Receiver::PENDING_STATUS => Yii::t('app', 'distribution_in_progress'),
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
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
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

                    <?= GridView::widget([
                        'dataProvider' => $dataProviderSacrifice,
                        'filterModel' => $searchModelSacrifice,
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
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' =>'text-align:center;'],
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'registration_year',
                                    'options' => ['class' => 'form-control', 'id' => 'registration-year-filter-sacrifice'],
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
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' =>'text-align:center;'],
                                'attribute' => 'clock',
                                'value' => function ($model) {
                                    return $model->clock;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'status',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' =>'text-align:center;'],
                                'value' => function ($model) {
                                    if ($model->receiverType->code == "QRN") {
                                        if ($model->status == Receiver::NOT_CLAIM) {
                                            return Html::a('<button class="btn btn-info">' . Yii::t('app', 'not_claimed') . '</button>',
                                                ['receiver/edit-coupon-status', 'id' => $model->id, 'status' => Receiver::CLAIM],
                                                ['data' => [
                                                    'confirm' => Yii::t('app', 'are_you_sure_want_to_claim_this_coupon_?')]
                                                ]);
                                        } elseif ($model->status == Receiver::CLAIM) {
                                            return '<button class="btn btn-secondary disable">'.Yii::t('app', 'already_claimed').'</button>';
                                        }
                                    }
                                },
                                'filter'=> [
                                    Receiver::NOT_CLAIM => Yii::t('app', 'not_claimed'),
                                    Receiver::CLAIM => Yii::t('app', 'already_claimed'),
                                ],
                            ],
                            
                            [
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' =>'text-align:center'],
                                'attribute' => 'status_update',
                                'value' => function ($model) {
                                    return $model->status_update ?? Yii::t('app', 'not_claimed');
                                },
                            ],
                        ],
                    ]); ?>
                </div>
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
    $('#registration-year-filter-sacrifice').on('click', function(){
        $(this).datepicker({
            changeYear: true,
            yearRange: '1900:' + new Date().getFullYear(),
            dateFormat: 'yy',
            showButtonPanel: true,
        }).focus();
    });
    $('#registration-year-filter-charity').on('click', function(){
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
