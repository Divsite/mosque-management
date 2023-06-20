<?php

use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use backend\models\Receiver;
use barcode\barcode\BarcodeGenerator;
use yii\helpers\Json;
use yii\rbac\Assignment;

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
                                'label' => 'Barcode',
                                'attribute' => 'barcode_number',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' =>'text-align:center;'],
                                'value' => function($model) {
                                    $optionsArray = array(
                                        'elementId'=> 'showBarcode' . '-' . $model->barcode_number,
                                        'value'=> $model->barcode_number,
                                        'type'=>'code128',
                                        'settings' => [
                                            'barWidth' => 1,
                                            'barHeight' => 70,
                                        ]
                                    );
                                    BarcodeGenerator::widget($optionsArray);
                                    return Html::a('<div id="showBarcode-'.$model->barcode_number.'"></div>', ['update', 'id' => $model->id]);
                                    
                                }
                            ],

                            // 'receiver_type_id',
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
                            // 'receiver_class_id',
                            // [
                            //     'format' => 'raw',
                            //     'headerOptions' => ['style' => 'text-align:center'],
                            //     'contentOptions' => ['style' =>'text-align:center;'],
                            //     'attribute' => 'receiver_class_id',
                            //     'filter' => ArrayHelper::map(ReceiverClass::find()->all(), 'id', 'name'),
                            //     'value' => function ($model) {
                            //         return $model->receiverClass ? $model->receiverClass->name : null;
                            //     },
                            // ],
                            // 'name',
                            // 'desc:ntext',
                            // 'citizens_association_id',
                            // 'neighborhood_association_id',
                            // 'registration_year',
                            //'qty',
                            // 'barcode_number',
                            
                            // 'status',

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
                                'format' => 'raw',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    if ($model->status == Receiver::NOT_CLAIM) {
                                        return Html::a('<button class ="btn btn-'. ($model->status == Receiver::NOT_CLAIM ? 'info' : 'secondary') .'"> '. ($model->status == Receiver::NOT_CLAIM ? '' : 'Sudah di ') .'Pakai Kupon </button>', ['receiver/edit-coupon-status', 'id' => $model->id, 'status' => ($model->status == Receiver::NOT_CLAIM ? Receiver::CLAIM : Receiver::NOT_CLAIM)], ['data' => ['confirm' => ($model->status == Receiver::NOT_CLAIM ? 'Apa Anda yakin pakai kupon ini?' : false)],]);
                                    } else if ($model->status == Receiver::CLAIM) {
                                        return '<button class="btn btn-secondary disable">'. Yii::t('app', 'already_claimed') .'</button>';
                                    } else {
                                        return '<button class="btn btn-secondary disable">'. Yii::t('app', 'coupon_not_valid') .'</button>';
                                    }
                                },
                                'filter'=>[
                                    1 => Yii::t('app', 'not_claimed'),
                                    2 => Yii::t('app', 'already_claimed'),
                                ],
                            ],
                            //'timestamp',

                            // [
                            //     'class' => 'yii\grid\ActionColumn',
                            //     'header' => 'Action',
                            //     'template' => '{delete}',
                            //     'buttons' => [
                            //     'view' => function($url, $model) {
                            //         return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                            //             ['view', 'id' => $model['id']], 
                            //             ['title' => 'View']);
                            //     },
                            //     'update' => function($url, $model) {
                            //         return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                            //             ['update', 'id' => $model['id']], 
                            //             ['title' => 'Update']);
                            //     },
                            //     'delete' => function($url, $model) {
                            //         return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                            //             ['delete', 'id' => $model['id']], 
                            //             ['title' => 'Delete',
                            //             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //             'data-method'  => 'post']);
                            //         }
                            //     ]
                            // ],
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
