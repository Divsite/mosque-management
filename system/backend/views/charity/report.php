<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'full_report_charity_receiver');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/dist/css/dataTables.bootstrap4.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'full_report_charity_receiver') ?></h3>
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
                    <h6 style="margin-top: auto;"><?= Yii::t('app', 'receiver_type') ?></h6>
                    <div class="pb-2">
                        <?php echo $this->render('_report-search-by-year'); ?>
                    </div>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <thead>
                            <tr>
                                <th><?= Yii::t('app', 'charity_type_source_id') ?></th>
                                <th><?= Yii::t('app', 'min') ?></th>
                                <th><?= Yii::t('app', 'max') ?></th>
                                <th><?= Yii::t('app', 'total_rice') ?></th>
                                <th><?= Yii::t('app', 'package') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($summaryCharityType->getModels() as $model): ?>
                                <tr>
                                    <td><?= $model->charitySource->name ?></td>
                                    <td><?= $model->min ? Yii::$app->formatter->asCurrency($model->min, 'IDR') : '-' ?></td>
                                    <td><?= $model->max ? Yii::$app->formatter->asCurrency($model->max, 'IDR') : '-' ?></td>
                                    <td><?= $model->total_rice ? $model->total_rice . ' LITER' : '-' ?></td>
                                    <td><?= $model->package ? Yii::$app->formatter->asCurrency($model->package, 'IDR') : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <h6><?= Yii::t('app', 'summary_report_for_charity_manually_by_charity_type') ?></h6>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <tbody>
                            <?php 
                            $summary = [];
                            $incomeTotal = 0;

                            foreach ($summaryCharityManually->getModels() as $model) {
                                $typeId = $model->charityType->id;
                                $typeName = $model->charityType->charitySource->name;
                                $paymentTotal = $model->charityManually->payment_total;

                                if (!isset($summary[$typeId])) {
                                    $summary[$typeId] = [
                                        'name' => $typeName,
                                        'total' => 0,
                                    ];
                                }

                                $summary[$typeId]['total'] += $paymentTotal;
                                $incomeTotal += $paymentTotal;
                            } 
                            ?>
                            <?php foreach ($summary as $item): ?>
                            <tr>
                                <td><strong><?= $item['name'] ?></strong></td>
                                <td><?= Yii::$app->formatter->asCurrency($item['total'], 'IDR') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td><strong><?= Yii::t('app', 'total_income') ?></strong></td>
                                <td><?= Yii::$app->formatter->asCurrency($incomeTotal, 'IDR') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h6><?= Yii::t('app', 'summary_report_for_charity_automatic_by_charity_type') ?></h6>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap">
                        <tbody>
                            <?php
                                $incomeTotalZakatFitrah = 0;
                                $incomeTotalZakatFidyah = 0;
                                $incomeTotalInfaq = 0;
                                $incomeTotalSodaqoh = 0;
                                $incomeTotalZakatMaal = 0;
                                $incomeTotalWaqaf = 0;
                                $totalIncome = 0;
                            ?>
                            <?php foreach ($summaryCharityAutomatic->getModels() as $model): ?>

                            <?php
                                $incomeTotalZakatFitrah += $model->charityZakatFitrah->payment_total ?? null;
                                $incomeTotalZakatFidyah += $model->charityZakatFidyah->payment_total ?? null;
                                $incomeTotalInfaq += $model->charityInfaq->payment_total ?? null;
                                $incomeTotalSodaqoh += $model->charitySodaqoh->payment_total ?? null;
                                $incomeTotalZakatMaal += $model->charityZakatMal->payment_total ?? null;
                                $incomeTotalWaqaf += $model->charityWaqaf->payment_total ?? null;

                                $totalIncome = $incomeTotalZakatFitrah + $incomeTotalZakatFidyah + $incomeTotalInfaq
                                            + $incomeTotalSodaqoh + $incomeTotalZakatMaal + $incomeTotalWaqaf;
                            ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= $model->charityType->charitySource->name ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php
                                        $charityCode = $model->charityType->charitySource->code;
                                        switch ($charityCode) {
                                            case "FTRH":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalZakatFitrah, 'IDR');
                                                break;
                                            case "FDYH":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalZakatFidyah, 'IDR');
                                                break;
                                            case "INFQ":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalInfaq, 'IDR');
                                                break;
                                            case "SQDH":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalSodaqoh, 'IDR');
                                                break;
                                            case "ZMAL":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalZakatMaal, 'IDR');
                                                break;
                                            case "WQAF":
                                                echo Yii::$app->formatter->asCurrency($incomeTotalWaqaf, 'IDR');
                                                break;
                                            default:
                                                echo '-';
                                                break;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td><strong><?= Yii::t('app', 'total_income') ?></strong></td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($totalIncome, 'IDR') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h6 style="margin-top: auto;">
                        <?= Yii::t('app', 'charity_report_daily_manually') ?>
                        <?= Html::a(
                            '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
                            ['charity/report'],
                            ['class' => 'btn btn-link', 'style' => 'margin-top: auto;']
                        ); ?>
                    </h6>
                    <div class="pb-2">
                        <?php echo $this->render('_report-search-by-daily'); ?>
                    </div>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table table-bordered table-nowrap table-report-daily">
                        <thead>
                            <tr>
                                <th><?= Yii::t('app', 'NO')?></th>
                                <th><?= Yii::t('app', 'customer_name') ?></th>
                                <th><?= Yii::t('app', 'customer_number') ?></th>
                                <th><?= Yii::t('app', 'total_rice') ?></th>
                                <th><?= Yii::t('app', 'payment_total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $summaryCharityDailyManuallyTotalMoney = 0;
                                $summaryCharityDailyManuallyTotalRice = 0;
                                $totalMuzakki = count($summaryCharityDailyManually->getModels());
                            ?>
                            <?php foreach ($summaryCharityDailyManually->getModels() as $index => $model): ?>
                            <?php
                                $summaryCharityDailyManuallyTotalMoney += $model->charityManually->payment_total;
                                $summaryCharityDailyManuallyTotalRice += $model->charityManually->total_rice;
                            ?>
                            <tr>
                                <td><?= $index++ ?></td>
                                <td><?= $model->charityManually->customer_name ?></td>
                                <td><?= $model->charityManually->customer_number ?></td>
                                <td><?= $model->charityManually && $model->charityManually->total_rice ? $model->charityManually->total_rice . ' LITER' : '-' ?></td>
                                <td><?= $model->charityManually->payment_total ? Yii::$app->formatter->asCurrency($model->charityManually->payment_total, 'IDR') : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold;">
                                <?= Yii::t('app', 'amount_rice') ?> :
                                <?= $summaryCharityDailyManuallyTotalRice ?>
                            </td>
                            <td style="font-weight: bold;">
                                <?= Yii::t('app', 'total_muzakki') ?> :
                                <?= $totalMuzakki ?>
                            </td>
                            <td style="font-weight: bold;">
                                <?= Yii::t('app', 'amount_money') ?> :
                                <?= Yii::$app->formatter->asCurrency($summaryCharityDailyManuallyTotalMoney, 'IDR') ?>
                            </td>
                        </tr>
                    </table>
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
var t = $('.table-report-daily').DataTable({
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

JS;

$this->registerJs($js);
?>