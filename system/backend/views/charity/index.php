<?php

use backend\models\Charity;
use backend\models\CharityType;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CharitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'charity');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-index">
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
                
                <?php if (Yii::$app->user->identity->can('create')) : ?>
                    <?= Html::a(Yii::t('app', 'create_charity'), ['create'], ['class' => 'btn btn-success btn-margin']) ?>
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
                            'attribute' => 'year',
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'year',
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
                            'attribute' => 'type',
                            'value' => function ($model) {
                                return $model->type == Charity::CHARITY_TYPE_MANUALLY ? Yii::t('app', 'charity_type_manually') : Yii::t('app', 'charity_type_automatic');
                            },
                            'filter'=>[
                                1 => Yii::t('app', 'charity_type_manually'),
                                2 => Yii::t('app', 'charity_type_automatic'),
                            ],
                        ],
                        
                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'type_charity_id',
                            'filter' => ArrayHelper::map(CharityType::find()->with('charitySource')->all(), 'id', 'charitySource.name'),
                            'value' => function ($model) {
                                return $model->charityType->charitySource->name;
                            },
                        ],

                        [
                            'format' => 'raw',
                            'attribute' => 'customer_name',
                            'label' => Yii::t('app', 'name'),
                            'value' => function ($model) {
                                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                                    return $model->charityManually ? $model->charityManually->customer_name : null;
                                } else {
                                    $customer = $model->findCharityAutomatic($model->type_charity_id);
                                    return $customer->customer_name ?? null;
                                }
                            },
                        ],
                        
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'telp'),
                            'value' => function ($model) {
                                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                                    return $model->charityManually ? $model->charityManually->customer_number : null;
                                } else {
                                    $customer = $model->findCharityAutomatic($model->type_charity_id);
                                    return $customer->customer_number ?? null;
                                }
                            },
                        ],
                        
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'payment_total'),
                            'value' => function ($model) {
                                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                                    return $model->charityManually ? Yii::$app->formatter->asCurrency($model->charityManually->payment_total, 'IDR') : null;
                                } else {
                                    $customer = $model->findCharityAutomatic($model->type_charity_id);
                                    return Yii::$app->formatter->asCurrency($customer->payment_total, 'IDR') ?? null;
                                }
                            },
                        ],
                        
                        [
                            'format' => 'raw',
                            'attribute' => 'payment_date',
                            'label' => Yii::t('app', 'payment_date'),
                            'value' => function ($model) {
                                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                                    return $model->charityManually ? $model->charityManually->payment_date : null;
                                } else {
                                    $customer = $model->findCharityAutomatic($model->type_charity_id);
                                    return $customer->payment_date ?? null;
                                }
                            },
                        ],
                        
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'total_rice'),
                            'value' => function ($model) {
                                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                                    return $model->charityManually ? $model->charityManually->total_rice . ' Liter' : null;
                                } else {
                                    return '-';
                                }
                            },
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{print-invoice} {delete}',
                            'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                    ['update', 'id' => $model['id']], 
                                    ['title' => 'Update']);
                            },
                            'print-invoice' => function($url, $model) {
                                return Html::a('<button class="btn btn-sm btn-warning"><i class="fa fa-print"></i></button>', 
                                    ['print-invoice', 'id' => $model['id']], 
                                    ['title' => 'Cetak Invoice', 'data' => 
                                    ['pjax' => 1]
                                ]);
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

        <div class="card-footer">
            <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
        </div>
        
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
