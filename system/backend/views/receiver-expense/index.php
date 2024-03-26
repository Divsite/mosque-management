<?php

use backend\models\ReceiverOperationalType;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use kartik\date\DatePicker;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'expenses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-expense">

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
                <?= Html::a(Yii::t('app', 'create_expense'), ['expense-create'], ['class' => 'btn btn-success btn-margin create-expense']) ?>
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
                            'attribute' => 'receiver_operational_code',
                            'filter' => ArrayHelper::map(ReceiverOperationalType::find()->all(), 'code', 'name'),
                            'value' => function ($model) {
                                return $model->operationalType->name;
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
                            'attribute' => 'amount',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asCurrency($model->amount, 'IDR');
                            },
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{update} {delete}',
                            'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['expense-update', 'id' => $model['id']], 
                                    ['title' => 'Update', 'class' => 'update-expense']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                    ['expense-delete', 'id' => $model['id']], 
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

    $(".create-expense").on("click", function(e) {
        e.preventDefault();
        url = $(this).attr('href');
        $('#createExpense')
            .modal('show')
            .find('.modal-body')
            .html('Loading ...')
            .load(url);
            return false;
    });
    
    $(".update-expense").on("click", function(e) {
        e.preventDefault();
        url = $(this).attr('href');
        $('#updateExpense')
            .modal('show')
            .find('.modal-body')
            .html('Loading ...')
            .load(url);
            return false;
    });
JS;

$this->registerJs($js);

Modal::begin([
    'id' => 'createExpense',
    'size' => Modal::SIZE_LARGE,
    'title' => Yii::t('app', 'create_expense'),
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
    'id' => 'updateExpense',
    'size' => Modal::SIZE_LARGE,
    'title' => Yii::t('app', 'update_expense'),
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
