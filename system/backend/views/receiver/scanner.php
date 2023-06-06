<?php

use yii\helpers\Url;
use yii\helpers\Html;

// get barcode 
$barcode = Yii::$app->request->get('barcode');
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
				<div class="row">
					<div class="col">
						<h4><?= Yii::t('app', 'input_number') ?><button type="button" class="btn information btn-outline-primary" style="padding: 0 8px">?</button>&nbsp;</h4>
						<div class="input-group">
							<input id="input" type="text" class="form-control" placeholder="<?= Yii::t('app', 'input_number') ?>" aria-label="<?= Yii::t('app', 'input_number') ?>" aria-describedby="basic-addon2" value="<?= $barcode ?>">
							<div class="input-group-append">
								<button id="enter" class="btn btn-outline-primary btn-icon"><i class="fa fa-check"></i></button>
								<button id="scan" class="btn btn-outline-primary btn-icon"><i class="fa fa-barcode"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="content" style="margin-top:16px;display:<?= !empty($receiver["data"]["barcode_number"]) ? "block" : "none" ?>">
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
								<td style="display: inline-block; width:100%;"><?= $receiver ? $receiver["data"]["status"] : null ?></td>
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
$formInformation = Yii::t('app', 'please_see_number_provided_on_the_blank_form_or_other_documents');

$js = <<< JS
function checkAndroid() {
    if (typeof Android !== "undefined" && Android !== null) {
        return true
    } else {
		swal.fire("Warning!", "$onlyAndroidMessage", "warning");
		return false
	}
}
$('#input').keypress(function(e) {
    if (e.keyCode == 13) {    
        $("#enter").click();
    }
});

$("#enter").click(function(e) {
    input = $('#input').val();
	
    if (input.match(/^QRN-BCH\d{3}-RW\d{2}-RT\d{1}-\d{4}-\d{3}$/)) {
        swal.fire({
            title: "Success!",
            text: "$coupon " + input + " $dataUpdated",
            icon: "success",
            timer: 50000,
        });
		window.location = '$urlTrace' + '?barcode=' + input;
    } else {
		swal.fire("Error!", "$failedNumberCoupon", "error");
    }
});

if ($('.content').is(":visible")) {
	swal.fire({
        title: "Success!",
        text: "$coupon $barcode $dataFound",
        icon: "success",
        timer: 1000,
    });
	if (checkAndroid()) {
		Android.showNotification(1, "$coupon $dataFound", "$barcode");
	}
} 

if ($('.content').is(":hidden")) {
	if ("$barcode" !== "") {
		swal.fire("Error!", "$dataNotFound", "error");
	}
}

$("#scan").click(function(e) {
    if (checkAndroid()) {
		$('.content').hide();
        Android.scanBarcode();
    }
});

$(".information").click(function(e) {
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