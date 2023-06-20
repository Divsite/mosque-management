<?php

use backend\models\Receiver;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'statistics_dashboard');
$this->params['page_title'] = Yii::t('app', 'dashboard');
$this->params['page_desc'] = Yii::t('app', 'all_information_statistics');
$this->params['title_card'] = Yii::t('app', 'all_information_statistics');

$this->registerCssFile('@web/dist/css/dataTables.bootstrap4.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/dist/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
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
                                <th><?= Yii::t('app', 'no')?></th>
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

<?php

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
function autoRefresh() {
    setTimeout(function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    setTimeout(function() {
        location.reload();
    }, 500); // Delay for smooth scrolling effect
  }, 15000); // Refresh interval in milliseconds (5 seconds in this example)
}

// Call the autoRefresh function to start the auto-refresh process
autoRefresh();

JS;

$css = <<< CSS

CSS;

$this->registerJs($js);
$this->registerCss($css);

?>
