<?php
namespace common\components;

use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeHelper
{
    public static function generate($value)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeData = $generator->getBarcode($value, $generator::TYPE_CODE_128);
        return 'data:image/png;base64,' . base64_encode($barcodeData);
    }
}
