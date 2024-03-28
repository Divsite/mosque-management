<?php

use backend\models\ReceiverIncomeType;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use kartik\date\DatePicker;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'incomes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-income">

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
                <?= Html::a(Yii::t('app', 'create_income'), ['income-create'], ['class' => 'btn btn-success btn-margin create-income']) ?>
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
                            'attribute' => 'receiver_income_type_id',
                            'filter' => ArrayHelper::map(ReceiverIncomeType::find()->all(), 'id', 'name'),
                            'value' => function ($model) {
                                return $model->receiverIncomeType->name;
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
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'amount_money',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asCurrency($model->amount_money, 'IDR');
                            },
                        ],
                        
                        [
                            'attribute' => 'amount_rice',
                            'value' => function ($model) {
                                if ($model->amount_rice) {
                                    return $model->amount_rice . ' LITER';
                                } else {
                                    return '-';
                                }
                            },
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{update} {delete}',
                            'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['income-update', 'id' => $model['id']], 
                                    ['title' => 'Update', 'class' => 'update-income']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                    ['income-delete', 'id' => $model['id']], 
                                    ['title' => 'Delete',
                                    'data-confirm' => Yii::t('app', 'are_you_sure_want_to_delete_this_item_?'),
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

    $(".create-income").on("click", function(e) {
        e.preventDefault();
        url = $(this).attr('href');
        $('#createIncome')
            .modal('show')
            .find('.modal-body')
            .html('Loading ...')
            .load(url);
            return false;
    });
    
    $(".update-income").on("click", function(e) {
        e.preventDefault();
        url = $(this).attr('href');
        $('#updateIncome')
            .modal('show')
            .find('.modal-body')
            .html('Loading ...')
            .load(url);
            return false;
    });
JS;

$this->registerJs($js);

Modal::begin([
    'id' => 'createIncome',
    'size' => Modal::SIZE_LARGE,
    'title' => Yii::t('app', 'create_income'),
    'closeButton' => [
        'id'=>'close-button',
        'class'=>'close',
        'data-dismiss' =>'modal',
    ],
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => true
    ],
]);
Modal::end();

Modal::begin([
    'id' => 'updateIncome',
    'size' => Modal::SIZE_LARGE,
    'title' => Yii::t('app', 'update_income'),
    'closeButton' => [
        'id'=>'close-button',
        'class'=>'close',
        'data-dismiss' =>'modal',
    ],
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => true
    ],
]);
Modal::end();

?>
