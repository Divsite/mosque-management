<?php
use yii\helpers\Url;
?>
<div class="table-responsive table-nowrap">
    <div class="row">
        <div class="col-12 col-sm-8 col-lg-6">
            <h6 class="text-muted"><b><?= Yii::t('app', 'image_documentation') ?></b></h6> 
            <ul class="list-group">
                <?php foreach ($model->receiverDocumentationImage as $index => $value) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php //echo "Foto " . ($index + 1); ?>
                        <div style="height: 50%">
                            <?php 
                            $image = $value['url'] && Yii::getAlias('@webroot') . '/backend' . $value['url'] ? $value['url'] : '';
                            $image = Url::base() . $image;
                            ?>
                            <img src="<?= $image ?>" class="img-fluid" alt="Foto Dokumentasi">
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-12 col-sm-4 col-lg-6">
            <h6 class="text-muted"><b><?= Yii::t('app', 'detail_distribution') ?></b></h6> 
            <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= Yii::t('app', 'name') ?> : <b><?= $receiverResident->resident->user->name ?></b>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= Yii::t('app', 'class') ?> : <b><?= $model->receiverClass ? $model->receiverClass->receiverClassSource->name : '-' ?></b>
                    </li>
            </ul>
        </div>
    </div>
</div>