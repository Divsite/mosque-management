<?php
use yii\helpers\Html;
use yii\helpers\Url;
use barcode\barcode\BarcodeGenerator;
use common\components\Helpers;

$this->title = Yii::t('app', 'print_barcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'print_barcode'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$chunkedReceivers = array_chunk($receivers, 40); // 7 baris x 5 kolom = 35 items per page
?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button id="print" class="btn btn-primary"><?= Yii::t('app', 'print_barcode') ?></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <?php foreach ($chunkedReceivers as $pageIndex => $chunk) : ?>
                <div class="printAreaPage">
                    <?php foreach ($chunk as $data) :
                        $image = $data->branch->bch_image && is_file(Yii::getAlias('@webroot') . $data->branch->bch_image)
                            ? $data->branch->bch_image
                            : '/images/no_photo.jpg';

                        $elementId = 'showBarcode-' . $data['barcode_number'];
                        $type = 'code128';

                        echo '<div class="cut-line-wrapper">';

                            $color = $data->is_committee ? '#000000' : Helpers::relationValue($data, 'neighborhood', 'color', '#000000');

                            echo '<div class="barcode-card" style="border: 3px solid ' . $color . ';">';

                                echo Html::img(Url::base() . $image, [
                                    'style' => 'max-height: 17mm; width: auto; display: block; margin: 0 auto 5px auto;'
                                ]);

                                echo '<div style="text-align: center; font-size: 10px;">';
                                    if ($data->is_committee) {
                                        $neighborhoodName = Yii::t('app', 'committee');
                                    } else {
                                        $neighborhoodRawName = Helpers::relationValue($data, 'neighborhood', 'name', null);
                                        if ($neighborhoodRawName) {
                                            $neighborhoodNumber = substr($neighborhoodRawName, 2);
                                            $paddedNumber = str_pad($neighborhoodNumber, 2, '0', STR_PAD_LEFT);
                                            $neighborhoodName = 'RT ' . $paddedNumber;
                                        } else {
                                            $neighborhoodName = '-';
                                        }
                                    }

                                    echo '<strong>' . strtoupper($data->branch->bch_name) . ' - ' . $neighborhoodName . '</strong><br>';
                                    echo '<div id="' . $elementId . '"></div>';
                                    echo '<div style="height: 4px;"></div>';
                                    echo '<div style="font-size: 9px; font-weight: bold; padding: 0; margin: 0; line-height: 1;">' . strtoupper(Yii::t('app', 'please_dont_damage_the_coupon')) . '</div>';
                                    echo '<div style="font-size: 9px; padding: 0; margin: 0; line-height: 1;">' . Yii::t('app', 'clock') . ' : ' . $data->clock . '</div>';

                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                        echo BarcodeGenerator::widget([
                            'elementId' => $elementId,
                            'value' => $data['barcode_number'],
                            'type' => $type,
                            'settings' => [
                                'barWidth' => 1,
                                'barHeight' => 25,
                            ],
                        ]);
                    endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $('#print').on('click', function() {
        window.print();
    });
JS;

$css = <<<CSS
.printAreaPage { /* setup based on A3 Page */
    display: grid;
    grid-template-columns: repeat(5, minmax(50mm, 1fr)); /* 5 columns in width (55 mm) */
    grid-auto-rows: 47mm;
    gap: 4mm; /* gap in the barcode card */
    padding: 3mm; /* padding for page */
    height: 420mm; 
    width: 297mm;
    outline: 1px dashed red;
    page-break-after: always; /* separate page */
    margin: 0
}

.barcode-card {
    /* background-color: rgba(255, 0, 0, 0.05); */
    padding: 5mm;
    box-sizing: border-box;
    font-size: 10px;
    page-break-inside: avoid;
    break-inside: avoid;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.cut-line-wrapper {
    border: 1px dashed gray;
    padding: 5px;
    height: 100%;
    box-sizing: border-box;
}

@media print {
    body {
        margin: 0;
        padding: 0;
    }
    .btn, .card-header, .card-tools {
        display: none !important;
    }
    .printAreaPage {
        margin-left: 0;
        padding-left: 0;
    }
    @page {
        size: A3 portrait;
        margin: 0;
    }
}
CSS;

$this->registerJs($js);
$this->registerCss($css);
?>
