<?php

use yii\helpers\Url;
use yii\helpers\Html;

$number = Yii::$app->request->get('number');

$this->title = Yii::t('app', 'scanner_barcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'scanner_barcode'), 'url' => ['scanner']];
$this->params['breadcrumbs'][] = $this->title;

// Include ZXing Android integration
$this->registerJsFile('@web/dist/js/android.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="scanner">
            <div class="row">
                <div class="col">
                    <h4><?= Yii::t('app', 'input_number') ?> 
                        <button type="button" class="btn sweet-1 btn-outline-primary" style="padding: 0 8px">?</button>
                    </h4>
                    <div class="input-group">
                        <input id="input" type="text" class="form-control" placeholder="<?= Yii::t('app', 'input_number') ?>" value="<?= Html::encode($number) ?>">
                        <div class="input-group-append">
                            <button id="enter" class="btn btn-outline-primary"><i class="fa fa-check"></i></button>
                            <button id="scan" class="btn btn-outline-primary"><i class="fa fa-barcode"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$urlTrace = Url::to(['receiver/claim'], true);

$onlyAndroidMessage = Yii::t('app', 'only_android_device_running');
$coupon = Yii::t('app', 'coupon');
$dataUpdated = Yii::t('app', 'data_updated');
$failedNumberCoupon = Yii::t('app', 'failed_number_coupon');
$dataFound = Yii::t('app', 'data_found');
$dataNotFound = Yii::t('app', 'data_not_found');
$successInput = Yii::t('app', 'success_input');
$formInformation = Yii::t('app', 'please_see_number_provided_on_the_blank_form_or_other_documents');
$serverErrorOccured = Yii::t('app', 'server_error_occured');

$js = <<<JS
$("#scan").click(function() {
    if (checkAndroidWithWarning()) {
        Android.scanBarcode(); // scan to android
    }
});

function checkAndroidWithWarning() {
	if (typeof Android !== "undefined" && Android !== null) { // checking android device
		return true;
	}

	Swal.fire("Warning!", "$onlyAndroidMessage", "warning");
	return false;
}

$(".sweet-1").click(function() {
    Swal.fire({
        title: 'Informasi',
        text: '$formInformation'
    });
});

function isAndroid() {
    return (typeof Android !== "undefined" && Android !== null);
}

$("#enter").click(function() {
    let input = $('#input').val().trim();

    if (input.match(/^[0-9a-zA-Z\s-]{1,20}$/)) {
        $.ajax({
            url: '{$urlTrace}',
            method: 'GET',
            data: { number: input },
            success: function(response) {
                if (response.success) {
                    swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        timer: 3000,
                    });

                    if (isAndroid()) {
                        Android.showNotification(1, response.message, input); // android notification
                    }

                    setTimeout(() => {
                        $('#input').val('');
                    }, 500);
                } else { // error validation
                    swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                    });
                }
            },
            error: function() { // error server
                swal.fire({
					title: "Error!",
					text: "$serverErrorOccured",
					icon: "error",
				});
            }
        });
    } else { // null input
		swal.fire({
			title: "Error!",
			text: "$failedNumberCoupon",
			icon: "error",
		});
    }
});
JS;

$css = <<<CSS
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
