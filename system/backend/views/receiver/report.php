<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\models\Receiver;

$this->title = Yii::t('app', 'full_report_charity_distribution');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/dist/css/dataTables.bootstrap4.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'full_report_charity_distribution') ?></h3>
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
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h6 style="margin-top: auto;"><?= Yii::t('app', 'summary_distribution_expense') ?></h6>
                    <div class="pb-2">
                        <?php echo $this->render('_report-search'); ?>
                    </div>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;"><?= Yii::t('app', 'receiver_class') ?></th>
                                <th colspan="3"><?= Yii::t('app', 'get_money') ?></th>
                                <th colspan="4"><?= Yii::t('app', 'get_rice') . ' (LITER)' ?></th>
                            </tr>
                            <tr>
                                <th><?= Yii::t('app', 'receiver_total') ?></th>
                                <th><?= Yii::t('app', 'receiver_money_total') ?></th>
                                <th><?= Yii::t('app', 'sub_total') ?></th>
                                <th><?= Yii::t('app', 'receiver_total') ?></th>
                                <th><?= Yii::t('app', 'receiver_money_total') ?></th>
                                <th><?= Yii::t('app', 'sub_total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $residentTotalInReceiverMoney = 0;
                                $totalMoney = 0;
                                $totalRice = 0;
                            ?>
                            <?php foreach ($summaryDistributionExpense->getModels() as $model): ?>
                                <?php
                                    $moneyTotal = $model->receiverClass->get_money;
                                    $riceTotal = $model->receiverClass->get_rice;
                                    
                                    $receiverMoneyTotal = count($model->receiverResidents);
                                    $subTotalMoney = $receiverMoneyTotal * $moneyTotal;

                                    $receiverRiceTotal = isset($model->receiverClass->get_rice) ? $receiverMoneyTotal : '-';
                                    $subTotalRice = is_numeric($receiverRiceTotal) ? $riceTotal * $receiverRiceTotal : '-';

                                    $residentTotalInReceiverMoney += $receiverMoneyTotal;
                                    $totalMoney += $subTotalMoney;
                                    if (is_numeric($subTotalRice)) {
                                        $totalRice += $subTotalRice;
                                    }
                                ?>
                                <tr>
                                    <td><?= $model->receiverClass->receiverClassSource->name ?></td>
                                    <td><?= $receiverMoneyTotal ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($moneyTotal, 'IDR'); ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($subTotalMoney, 'IDR'); ?></td>
                                    <td><?= $receiverRiceTotal ?></td>
                                    <td><?= $riceTotal ?></td>
                                    <td><?= $subTotalRice ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td><strong><?= Yii::t('app', 'total') ?></strong></td>
                                <td><strong><?= $residentTotalInReceiverMoney ?></strong></td>
                                <td><strong>-</strong></td>
                                <td><strong><?= Yii::$app->formatter->asCurrency($totalMoney, 'IDR') ?></strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong><?= $totalRice ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <h6><?= Yii::t('app', 'summary_general_expense') ?></h6>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <tbody>
                            <?php
                                $amountTotal = 0;
                            ?>
                            <?php foreach ($summaryGeneralExpense->getModels() as $model): ?>
                            <?php
                                $amountTotal += $model->amount;
                            ?>
                            <tr>
                                <td><strong><?= $model->operationalType->name ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($model->amount, 'IDR') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td><strong><?= Yii::t('app', 'general_expense') ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($amountTotal, 'IDR') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h6><?= Yii::t('app', 'summary_expense_total') ?></h6>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <tbody>
                            <?php
                                $allTotalExpense = $amountTotal + $totalMoney;
                            ?>
                            <tr>
                                <td><strong><?= Yii::t('app', 'general_expense') ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($amountTotal, 'IDR') ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?= Yii::t('app', 'distribution_expense') ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($totalMoney, 'IDR') ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?= Yii::t('app', 'all_total_expense') ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($allTotalExpense, 'IDR') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'full_report_sacrifice_distribution') ?></h3>
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
        <div class="row" style="margin: 3px;">
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= Yii::$app->formatter->asInteger(Receiver::getTotalCouponByBranch()); ?></h3>
                        <p><?= Yii::t('app', 'all_total_qurban_coupon') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="#" class="small-box-footer"><?= Yii::t('app', 'more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= Yii::$app->formatter->asInteger(Receiver::getClaimStatusCouponByBranch()); ?></h3>
                        <p><?= Yii::t('app', 'all_total_claim_qurban_coupon') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <a href="#" class="small-box-footer"><?= Yii::t('app', 'more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= Yii::$app->formatter->asInteger(Receiver::getNotClaimStatusCouponByBranch()); ?><sup style="font-size: 20px"></sup></h3>
                        <p><?= Yii::t('app', 'all_total_not_claim_qurban_coupon') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-times"></i>
                    </div>
                <a href="#" class="small-box-footer"><?= Yii::t('app', 'more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-header">
            <h3 class="card-title"><?= Yii::t('app', 'total_qurban_coupon_by_neighborhood') ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                    <i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <div class="record-leave-view">
                        <div class="table-responsive table-nowrap">
                            <table class="table table-bordered table-nowrap table-leave">
                                <thead>
                                    <tr>
                                        <th><?= Yii::t('app', 'NO')?></th>
                                        <th><?= Yii::t('app', 'class')?></th>
                                        <th><?= Yii::t('app', 'total_qurban_coupon')?></th>
                                        <th><?= Yii::t('app', 'total_claim_qurban_coupon')?></th>
                                        <th><?= Yii::t('app', 'total_not_claim_qurban_coupon')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($totalCouponQurbanByClass as $data): ?>
                                        <tr>
                                            <td><?= $data['no'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['total_qurban_coupon'] ?></td>
                                            <td><?= $data['total_claim_qurban_coupon'] ?></td>
                                            <td><?= $data['total_not_claim_qurban_coupon'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$css = <<< CSS

table {
    width: 100%;
}
th, td {
    text-align: center;
}
CSS;

$js = <<< JS
var t = $('.table-leave').DataTable({
    "order": [[ 3, "desc" ]],
    "columnDefs": [
        { "orderable": false, "targets": 0 }
    ]
});

t.on( 'order.dt search.dt', function () {
    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

// Auto-refresh the page with a smooth transition every 5 seconds
// function autoRefresh() {
//     setTimeout(function() {
//     window.scrollTo({
//         top: 0,
//         behavior: 'smooth'
//     });
//     setTimeout(function() {
//         location.reload();
//     }, 500);
//   }, 15000); // Refresh interval in milliseconds (5 seconds in this example)
// }
// autoRefresh();

JS;

$this->registerCss($css);
$this->registerJs($js);
?>