<?php

use yii\helpers\Url;
use yii\helpers\Html;

$number = Yii::$app->request->get('number');

$this->title = Yii::t('app', 'scanner_barcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'scanner_barcode'), 'url' => ['scanner']];
$this->params['breadcrumbs'][] = $this->title;


// call CSS and JS by Zxing Barcode
$this->registerJsFile('@web/dist/js/android.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
			<div class="scanner">
				<!-- =============== Barcode By Zxing Webview =============== -->
				<div class="row">
					<div class="col">
						<h4><?= Yii::t('app', 'input_number') ?> <button type="button" class="btn sweet-1 btn-outline-primary" style="padding: 0 8px">?</button></h4>
						<div class="input-group">
							<input id="input" type="text" class="form-control" placeholder="<?= Yii::t('app', 'input_number') ?>" aria-label="<?= Yii::t('app', 'input_number') ?>" aria-describedby="basic-addon2" value="<?= $number ?>">
							<div class="input-group-append">
								<button id="enter" class="btn btn-outline-primary btn-icon"><i class="fa fa-check"></i></button>
								<button id="scan" class="btn btn-outline-primary btn-icon"><i class="fa fa-barcode"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="isi" style="margin-top:16px;display:<?= !empty($receiver["data"]["barcode_number"]) ? "block" : "none" ?>">
				<h2 class="table-header"><?= Yii::t('app', 'detail_receiver') ?></h2>
				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th><?= Yii::t('app', 'barcode_number') ?></th>
								<th><?= Yii::t('app', 'branch_code') ?></th>
								<th><?= Yii::t('app', 'receiver_type_id') ?></th>
								<th><?= Yii::t('app', 'citizens_association_id') ?></th>
								<th><?= Yii::t('app', 'neighborhood_association_id') ?></th>
								<th><?= Yii::t('app', 'status') ?></th>
								<th><?= Yii::t('app', 'status_update') ?></th>
								<th><?= Yii::t('app', 'user_id') ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $receiver ? $receiver["data"]["barcode_number"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["branch_code"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["receiver_type_id"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["citizens_association_id"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["neighborhood_association_id"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["status"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["status_update"] : null ?></td>
								<td><?= $receiver ? $receiver["data"]["user_id"] : null ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="empty" style="display:<?= !empty($receiver) ? "none" : "block"?>">
				<span style="text-align: center; display: block">
					<?= Yii::t('app', 'check_and_make_sure_again_that_the_number_entered_is_correct') ?>
				</span>
			</div>
		</div>
	</div>
</div>

<?php

$urlTrace = Url::to(['receiver/scanner']);

$onlyAndroidMessage = Yii::t('app', 'only_android_device_running');
$coupon = Yii::t('app', 'coupon');
$dataUpdated = Yii::t('app', 'data_updated');
$failedNumberCoupon = Yii::t('app', 'failed_number_coupon');
$dataFound = Yii::t('app', 'data_found');
$dataNotFound = Yii::t('app', 'data_not_found');
$successInput = Yii::t('app', 'success_input');
$formInformation = Yii::t('app', 'please_see_number_provided_on_the_blank_form_or_other_documents');

$js = <<< JS
// =========== Custom ============
function checkAndroid() {
    if (typeof Android !== "undefined" && Android !== null) {
        return true
    }
    swal.fire("Warning!", "$onlyAndroidMessage", "warning");
    return false
}
$('#input').keypress(function(e) {
    if (e.keyCode == 13) {    
        $("#enter").click();
    }
});

$("#enter").click(function(e) {
    input = $('#input').val();
    if (input.match(/^[0-9a-zA-Z\s-]{1,20}$/)) {
        swal.fire({
            title: "Success!",
            text: "$coupon " + input + " $successInput",
            icon: "success",
            timer: 5000,
        });
		window.location = '$urlTrace' + '?number=' + input;
    } else {
        swal.fire("Error!", "$failedNumberCoupon", "error");
    }
});
if ($('.isi').is(":visible")) {
	swal.fire({
        title: "Success!",
        text: "$coupon $number $dataFound dan $dataUpdated",
        icon: "success",
        timer: 4000,
    });
	if (checkAndroid()) {
		Android.showNotification(1,"$coupon $dataFound", "$number");
	}
} 

if ($('.isi').is(":hidden")) {
	if ("$number" !== "") {
		swal.fire("Error!", "$dataNotFound", "error");
	}
}

$("#scan").click(function(e) {
    if (checkAndroid()) {
    	$('.isi').hide();
        Android.scanBarcode();
    }
});

$(".sweet-1").click(function(e) {
    swal.fire({
		title: 'Informasi', 
		text: '$formInformation'
    });
});
JS;

$css = <<< CSS
.table td, .table th {
	padding: 5px;
}

.table-header {
	background: #4099ff;
	font-size: 13px;
	padding: 6px;
	color: #fff;
}
CSS;

$this->registerCss($css);
$this->registerJs($js);

?>