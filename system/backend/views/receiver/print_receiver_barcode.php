<?php

use yii\helpers\Html;
use backend\models\Receiver;
use backend\models\ReceiverType;
use barcode\barcode\BarcodeGenerator;
use yii\helpers\Url;

$this->title = Yii::t('app', 'print_barcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'print_barcode'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
				<div id="printArea">
					<?php
                        
                        $receiver = Receiver::find()
                        ->with(['receiverType', 'branch'])
                        ->where(['branch_code' => Yii::$app->user->identity->code, 'receiver_type_id' => ReceiverType::SACRIFICE])
                        ->all();
                        
                        echo '<div class="row">';
                            foreach ($receiver as $key => $data) {

                                $image = $data->branch->bch_image && is_file(Yii::getAlias('@webroot') . $data->branch->bch_image) ? $data->branch->bch_image : '../images/no_photo.jpg';

                                $elementId = 'showBarcode' . '-' . $data['barcode_number'];
                                $type = 'code128';
                                BarcodeGenerator::widget(array(
                                    'elementId' => $elementId, 
                                    'value' => $data['barcode_number'], 
                                    'type' => $type,
                                    'settings' => [
                                        'barWidth' => 2,
                                        'barHeight' => 70,
                                    ]
                                ));
                                
                                echo '<div class="col-lg-6">';
                                    echo  '<div class="card cards" style="">';
                                        echo '<div class="card-body card-bodys" style="border: 3px solid ' . $data->neighborhood->color . '">';
                                            echo '<div class="col-lg-12">';
                                                echo '<center>';
                                                    echo Html::img(Url::base().$image, ['height' => '80', 'style' => '']);
                                                    echo '<br>';
                                                    $neighborhoodNumber = substr($data->neighborhood->name, 2); // Mengambil angka dari teks, misalnya "1", "2", "3"
                                                    $paddedNumber = str_pad($neighborhoodNumber, 2, '0', STR_PAD_LEFT); // Menambahkan padding "0" di depan angka
                                                    $neighborhoodName = 'RT ' . $paddedNumber; // Menggabungkan teks "RT" dengan angka yang sudah dipad
                                                    echo '<b>' . strtoupper($data->branch->bch_name) .' - '. $neighborhoodName . '</b>';
                                                    echo '<div id="showBarcode-'.$data['barcode_number'].'"></div>';
                                                echo '</center>';
                                                echo '<div style="font-style: italic; font-size: 12px;">';
                                                    echo strtoupper(Yii::t('app', 'please_dont_damage_the_coupon'));
                                                    echo '<div style="font-size: 12px; float: right; !important">';
                                                        echo Yii::t('app', 'clock') .' :' . $data->clock;
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        echo '</div>';
					?>
				</div>
				<button id="print" class="btn btn-primary"><?= Yii::t('app', 'print_barcode') ?></button>
		</div>
	</div>
</div>

<?php
$js = <<< JS

$('#print').on('click', function(e) {
	var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
});

window.onafterprint = function() {
    window.location.reload(true);
}

JS;

$css = <<< CSS
.cards {
    color: black; 
    border: 1px solid #7f8c8d;
}
.cards .card-bodys {
    padding: 5px; 
    margin-bottom: 15px; 
    margin-top: 15px; 
    margin-right: 15px; 
    margin-left: 15px; 
}
CSS;
$this->registerJs($js);
$this->registerCss($css);

?>