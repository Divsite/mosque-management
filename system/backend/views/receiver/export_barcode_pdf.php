<?php
use common\components\BarcodeHelper;
?>
<div class="barcode-grid">
    <?php foreach ($receiver as $data): ?>
        <div class="barcode-card">
            
            <div class="barcode-label">
                <?= strtoupper($data->branch->bch_name) ?> - RT <?= str_pad(substr($data->neighborhood->name, 2), 2, '0', STR_PAD_LEFT) ?>
            </div>
            
            <img src="<?= BarcodeHelper::generate($data->barcode_number) ?>" height="60">
            
            <div><i><?= Yii::t('app', 'please_dont_damage_the_coupon') ?></i></div>
            <div style="font-size: 10px"><?= Yii::t('app', 'clock') ?>: <?= $data->clock ?></div>
        </div>
    <?php endforeach; ?>
</div>