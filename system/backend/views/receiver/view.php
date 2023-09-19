<?php

use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use barcode\barcode\BarcodeGenerator;
use backend\models\Receiver;
use backend\models\ReceiverClass;
use backend\models\ReceiverResident;
use backend\models\ReceiverType;
use backend\models\User;
use backend\models\Village;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */

$this->title = $model->receiverType->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/dist/css/dataTables.bootstrap4.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="card table-card">
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
        <div class="card-text">
            <div class="receiver-view">
                
                <p>
                    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>

                <?php if ($model->receiver_type_id == ReceiverType::ZAKAT) : ?>
                    
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            [
                                'format' => 'raw',
                                'attribute' => 'receiver_type_id',
                                'filter' => ArrayHelper::map(ReceiverType::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->receiverType->name;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'receiver_class_id',
                                'filter' => ArrayHelper::map(ReceiverClass::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->receiverClass ? $model->receiverClass->name : null;
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
                                'attribute' => 'citizens_association_id',
                                'filter' => ArrayHelper::map(CitizensAssociation::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->citizens->name;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'neighborhood_association_id',
                                'filter' => ArrayHelper::map(NeighborhoodAssociation::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->neighborhood->name;
                                },
                            ],
                            'desc',
                            'registration_year',
                            [
                                'format' => 'raw',
                                'attribute' => 'user_id',
                                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->user->name;
                                },
                            ],
                        ],
                    ]) ?>

                    <div class="card table-card">
                        <div class="card-header">
                        <h3 class="card-title"><?= Yii::t('app', 'officer_id') ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                                <i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="receiver-officer-view">
                                    <div class="table-responsive table-nowrap">
                                        <table class="table table-bordered table-nowrap table-officers">
                                            <thead>
                                                <tr>
                                                    <th><?= Yii::t('app', 'ID') ?></th>
                                                    <th><?= Yii::t('app', 'name') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach ($model->listOfficers() as $officer): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $officer->officer->user->name?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card table-card">
                        <div class="card-header">
                        <h3 class="card-title"><?= Yii::t('app', 'resident_id') ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                                <i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="receiver-officer-view">
                                    <div class="table-responsive table-nowrap">
                                        <table class="table table-bordered table-nowrap table-residents">
                                            <thead>
                                                <tr>
                                                    <th><?= Yii::t('app', 'ID') ?></th>
                                                    <th><?= Yii::t('app', 'name') ?></th>
                                                    <th><?= Yii::t('app', 'status_distribution') ?></th>
                                                    <th><?= Yii::t('app', 'status_update') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach ($model->listResidents() as $resident): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $resident->resident->user->name?></td>
                                                        <td>
                                                            <?php
                                                                if ($resident->status == ReceiverResident::NOT_CLAIM) {
                                                                    echo Html::a(
                                                                        '<button class="btn btn-info">Pakai Kupon</button>',
                                                                        ['receiver/alms-coupon-claim', 'id' => $resident->id, 'status' => ReceiverResident::CLAIM, 'receiverId' => $model->id],
                                                                        ['data' => ['confirm' => 'Apa Anda yakin pakai kupon ini?']]
                                                                    );
                                                                } elseif ($resident->status == ReceiverResident::CLAIM) {
                                                                    echo '<button class="btn btn-secondary disable">'.Yii::t('app', 'has_been_distributed').'</button>';
                                                                } else {
                                                                    echo '<button class="btn btn-secondary disable">'.Yii::t('app', 'coupon_not_valid').'</button>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= $resident->status_update ? $resident->status_update : Yii::t('app', 'not_yet_update') ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else : ?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'format' => 'raw',
                                'attribute' => 'receiver_type_id',
                                'filter' => ArrayHelper::map(ReceiverType::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->receiverType->name;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'village_id',
                                'filter' => ArrayHelper::map(Village::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->village->name;
                                },
                            ],
    
                            [
                                'format' => 'raw',
                                'attribute' => 'citizens_association_id',
                                'filter' => ArrayHelper::map(CitizensAssociation::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->citizens->name;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'neighborhood_association_id',
                                'filter' => ArrayHelper::map(NeighborhoodAssociation::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->neighborhood->name;
                                },
                            ],

                            [
                                'format' => 'raw',
                                'label' => 'Barcode',
                                'attribute' => 'barcode_number',
                                'value' => function($model) {
                                    $optionsArray = array(
                                        'elementId'=> 'showBarcode' . '-' . $model->barcode_number,
                                        'value'=> $model->barcode_number,
                                        'type'=>'code128',
                                        'settings' => [
                                            'barWidth' => 2,
                                            'barHeight' => 100,
                                        ]
                                    );
                                    BarcodeGenerator::widget($optionsArray);
                                    return Html::a('<div id="showBarcode-'.$model->barcode_number.'"></div>', ['update', 'id' => $model->id]);
                                    
                                }
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

                            'registration_year',

                            [
                                'format' => 'raw',
                                'attribute' => 'user_id',
                                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
                                'value' => function ($model) {
                                    return $model->user->name;
                                },
                            ],

                            'status_update',
                            'clock',
                        ],

                    ]) ?>

                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<?php

$js = <<< JS

var officers = $('.table-officers').DataTable({
    "order": [[ 0, "desc" ]],
    "columnDefs": [
        { "orderable": false, "targets": 0 }
    ]
});

officers.on( 'order.dt search.dt', function () {
    officers.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

var residents = $('.table-residents').DataTable({
    "order": [[ 0, "desc" ]],
    "columnDefs": [
        { "orderable": false, "targets": 0 }
    ]
});

residents.on( 'order.dt search.dt', function () {
    residents.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

JS;

$this->registerJs($js);
?>